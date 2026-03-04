# Table of Contents

* [Installation](#installation)
* [Usage](#usage)
* [Available Types](#available-types)
  * [Thing](#thing)
  * [Person](#person)
  * [Organization](#organization)
  * [Place](#place)
  * [PostalAddress](#postaladdress)
  * [Offer](#offer)
  * [Event](#event)
  * [MusicEvent](#musicevent)
  * [MusicComposition](#musiccomposition)

## Installation

Installation is done via [Composer](https://getcomposer.org):

`composer require clubdeuce/schema-php`

## Usage

The primary impetus for this project was to implement a library to add schema information __*(primarily in the form of ld-json)*__ to web pages. The primary method is `schema()`, which returns an array with the default properties required by the schema.org specification added to the properties set by the application __*(e.g. @type, @context, etc)*__. The `ldJson()` method wraps the schema array in a `<script type="application/ld+json">` tag for direct embedding in HTML.

Use `SchemaFactory` to instantiate schema types:

```php
use Clubdeuce\Schema\SchemaFactory;

require 'vendor/autoload.php';

$factory = new SchemaFactory();
$person  = $factory->makePerson();

$person->setName('Jane Doe');
$person->schema();

/**
 * Will return:
 *
 * [
 *   '@context' => 'https://schema.org',
 *   '@type'    => 'Person',
 *   'name'     => 'Jane Doe'
 * ]
 */
```

As a convenience, items can be instantiated with property values as well:

```php
$person = $factory->makePerson([
    'name' => 'Cad Bane',
]);

$person->schema();
```

To output a `<script>` tag ready for use in HTML:

```php
echo $person->ldJson();
// <script type="application/ld+json">{"@context":"https://schema.org","@type":"Person","name":"Cad Bane"}</script>
```

## Available Types

### Thing

Base class for all schema types. All types inherit these properties and methods.

**Properties:** `name`, `description`, `imageUrl`, `url`

**Methods:**
- `setName(string $name): static`
- `setDescription(string $description): static`
- `setImageUrl(string $url): static`
- `setUrl(string $url): static`
- `schema(): array` — returns the schema.org-compliant array
- `ldJson(): string` — returns a `<script type="application/ld+json">` tag

### Person

Represents a person. Extends `Thing`.

**`SchemaFactory` method:** `makePerson(array $data = [])`

```php
$person = $factory->makePerson(['name' => 'Jane Doe']);
```

### Organization

Represents an organization. Extends `Thing`.

**`SchemaFactory` method:** `makeOrganization(array $data = [])`

**Additional properties:** `address` (`PostalAddress`), `telephone`

```php
$org = $factory->makeOrganization([
    'name'      => 'Acme Corp',
    'telephone' => '+1-800-555-0100',
    'address'   => [
        'streetAddress'   => '123 Main St',
        'addressLocality' => 'Springfield',
        'addressRegion'   => 'IL',
        'postalCode'      => '62701',
    ],
]);
```

The `address` key accepts either an array (auto-converted to a `PostalAddress` instance) or a `PostalAddress` object.

### Place

Represents a location. Extends `Thing`.

**`SchemaFactory` method:** `makePlace(array $data = [])`

**Additional properties:** `address` (`PostalAddress`)

```php
$place = $factory->makePlace([
    'name'    => 'Symphony Hall',
    'address' => ['streetAddress' => '301 Massachusetts Ave', 'addressLocality' => 'Boston'],
]);
```

### PostalAddress

Represents a mailing address. Extends `Thing`.

**`SchemaFactory` method:** `makePostalAddress(array $data = [])`

**Additional properties:** `streetAddress`, `addressLocality` (city), `addressRegion` (state), `postalCode`, `addressCountry`

**Methods:** `setStreetAddress()`, `setAddressLocality()`, `setAddressRegion()`, `setPostalCode()`, `setAddressCountry()`

### Offer

Represents a commercial offer. Extends `Thing`.

**`SchemaFactory` method:** `makeOffer(array $data = [])`

**Additional properties:** `price` (float, default `0`), `priceCurrency` (string, default `'USD'`)

**Methods:** `setPrice(float $price)`, `setPriceCurrency(string $currency)`

```php
$offer = $factory->makeOffer(['price' => 25.00, 'priceCurrency' => 'USD']);
```

### Event

Represents an event. Extends `Thing`.

**`SchemaFactory` method:** *(use `MusicEvent` or instantiate `Event` directly)*

**Additional properties:** `startDate`, `endDate`, `doorTime`, `duration` (`DateInterval`), `eventStatus`, `place` (`Place`), `performers`, `organizers`, `sponsors`, `directors`, `offers`

**Methods:**
- `setStartDate(DateTime $date)`, `setEndDate(DateTime $date)`, `setDoorTime(DateTime $time)`
- `setDuration(DateInterval $duration)` — if set and `endDate` is absent, `endDate` is computed automatically
- `setEventStatus(string $status)` — default `'EventScheduled'`
- `setPlace(Place $place)`
- `addPerformer(Organization|Person $performer)`, `addOrganizer(Organization|Person $organizer)`
- `addSponsor(Organization|Person $sponsor)`, `addDirector(Person $person)`
- `addOffer(Offer $offer)`

### MusicEvent

Represents a music event. Extends `Event`.

**`SchemaFactory` method:** `makeMusicEvent(array $data = [])`

Inherits all `Event` properties. Adds `composers` (array of `Person`).

**Methods:** `addComposer(Person $person)`

```php
$event = $factory->makeMusicEvent(['name' => 'Opening Night']);
$event->setStartDate(new DateTime('2025-09-15T19:30:00'));
$event->addPerformer($factory->makePerson(['name' => 'Jane Doe']));
$event->addComposer($factory->makePerson(['name' => 'Ludwig van Beethoven']));
```

### MusicComposition

Represents a musical work. Extends `Thing`.

**`SchemaFactory` method:** `makeMusicComposition(array $data = [])`

**Additional properties:** `composer` (`Person`), `lyricist` (`Person`), `form` (musical form string, e.g. `'Sonata'`)

**Methods:** `setComposer(Person $person)`, `setLyricist(Person $person)`, `setForm(string $form)`

```php
$composition = $factory->makeMusicComposition(['name' => 'Symphony No. 5']);
$composition->setComposer($factory->makePerson(['name' => 'Ludwig van Beethoven']));
$composition->setForm('Symphony');
```
