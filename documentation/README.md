# Table of Contents

* [Installation](#installation)
* [Usage](#usage)
  
## Installation

Installation is done via [Composer](https://getcomposer.org):

`composer require clubdeuce/schema-php`

## Usage

The primary impetus for this project was to implement a library to add schema information __*(primarily in the form of ld-json)*__ to web pages.  As such, the primary method is `schema()` which returns an array with the default properties required by the schema.org specification added to the properties set by the application __*(e.g. @type, @context, etc)*__.

```
use Clubdeuce\Schema\Schema;

require 'vendor/autoload.php';

$schema = new Schema();
$person = $schema->make_person();

$person->set_name('Jane Doe');
$person->schema();

/**
 * Will return:
 *
 * Array[
 *   '@context' => 'https://schema.org',
 *   '@type'    => 'Person',
 *   'name'     => 'Jane Doe'
 * ]
 */
```

As a convenience, items can be instantiated with property values as  well:

```
$person = $schema->make_person([
    'name'   => 'Cad Bane',
]);

$person->schema();
```
