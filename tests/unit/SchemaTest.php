<?php

namespace Clubdeuce\Schema\tests\unit;

use Clubdeuce\Schema\Offer;
use Clubdeuce\Schema\Organization;
use Clubdeuce\Schema\Person;
use Clubdeuce\Schema\Place;
use Clubdeuce\Schema\PostalAddress;
use Clubdeuce\Schema\Schema;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;


#[UsesClass(Person::class)]
#[UsesClass(Offer::class)]
#[UsesClass(Organization::class)]
#[UsesClass(Place::class)]
#[UsesClass(PostalAddress::class)]
#[CoversClass(Schema::class)]
class SchemaTest extends TestCase
{
    public function testMakePersonPassesDataToPerson()
    {
        $data = [
            'name' => 'John Doe',
            'description' => 'A test person',
            'image_url' => 'http://example.com/image.jpg'
        ];

        $schema = new Schema();
        $person = $schema->makePerson($data);

        $this->assertEquals('John Doe', $person->name());
        $this->assertEquals('A test person', $person->description());
        $this->assertEquals('http://example.com/image.jpg', $person->image_url());
    }

    public function testMakeMusicCompositionPassesDataToMusicComposition()
    {
        $data = [
            'name' => 'Symphony No. 5',
            'description' => 'A famous symphony composed by Beethoven',
            'image_url' => 'http://example.com/symphony.jpg',
            'url' => 'http://example.com/symphony',
        ];

        $schema = new Schema();
        $composition = $schema->makeMusicComposition($data);

        $this->assertEquals('Symphony No. 5', $composition->name());
        $this->assertEquals('A famous symphony composed by Beethoven', $composition->description());
        $this->assertEquals('http://example.com/symphony.jpg', $composition->image_url());
        $this->assertEquals('http://example.com/symphony', $composition->url());
    }

    public function testMakeMusicEventPassesDataToMusicEvent()
    {
        $data = [
            'name' => 'Jazz Night',
            'description' => 'A night of smooth jazz music',
            'image_url' => 'http://example.com/jazznight.jpg',
            'url' => 'http://example.com/jazznight',
        ];

        $schema = new Schema();
        $musicEvent = $schema->makeMusicEvent($data);

        $this->assertEquals('Jazz Night', $musicEvent->name());
        $this->assertEquals('A night of smooth jazz music', $musicEvent->description());
        $this->assertEquals('http://example.com/jazznight.jpg', $musicEvent->image_url());
        $this->assertEquals('http://example.com/jazznight', $musicEvent->url());
    }

    public function testMakeOfferPassesDataToOffer()
    {
        $data = [
            'name' => 'Special Discount Offer',
            'description' => 'An exclusive discount offer for a limited time',
            'image_url' => 'http://example.com/offer.jpg',
            'url' => 'http://example.com/offer',
            'price' => 99.99,
            'priceCurrency' => 'USD'
        ];

        $schema = new Schema();
        $offer = $schema->makeOffer($data);

        $this->assertEquals('Special Discount Offer', $offer->name());
        $this->assertEquals('An exclusive discount offer for a limited time', $offer->description());
        $this->assertEquals('http://example.com/offer.jpg', $offer->image_url());
        $this->assertEquals('http://example.com/offer', $offer->url());
        $this->assertEquals(99.99, $offer->price());
        $this->assertEquals('USD', $offer->priceCurrency());
    }

    public function testMakeOrganizationPassesDataToOrganization()
    {
        $data = [
            'name' => 'TechCorp',
            'description' => 'A leading technology company',
            'image_url' => 'http://example.com/logo.jpg',
            'url' => 'http://example.com',
            'telephone' => '123-456-7890',
            'address' => [
                'streetAddress' => '123 Tech Street',
                'addressLocality' => 'Tech City',
                'addressRegion' => 'Tech State',
                'postalCode' => '12345',
                'addressCountry' => 'Techland'
            ]
        ];

        $schema = new Schema();
        $organization = $schema->makeOrganization($data);

        $this->assertEquals('TechCorp', $organization->name());
        $this->assertEquals('A leading technology company', $organization->description());
        $this->assertEquals('http://example.com/logo.jpg', $organization->image_url());
        $this->assertEquals('http://example.com', $organization->url());
        $this->assertEquals('123-456-7890', $organization->telephone());
        $this->assertInstanceOf(PostalAddress::class, $organization->address());
        $this->assertEquals('123 Tech Street', $organization->address()->streetAddress());
        $this->assertEquals('Tech City', $organization->address()->addressLocality());
        $this->assertEquals('Tech State', $organization->address()->addressRegion());
        $this->assertEquals('12345', $organization->address()->postalCode());
        $this->assertEquals('Techland', $organization->address()->addressCountry());
    }


    public function testMakePlacePassesDataToPlace()
    {
        $data = [
            'name' => 'Central Park',
            'description' => 'A large public park in New York City.',
            'image_url' => 'http://example.com/centralpark.jpg',
            'url' => 'http://example.com/centralpark',
            'address' => [
                'streetAddress' => '59th to 110th St',
                'addressLocality' => 'New York',
                'addressRegion' => 'NY',
                'postalCode' => '10022',
                'addressCountry' => 'USA'
            ]
        ];

        $schema = new Schema();
        $place = $schema->makePlace($data);

        $this->assertEquals('Central Park', $place->name());
        $this->assertEquals('A large public park in New York City.', $place->description());
        $this->assertEquals('http://example.com/centralpark.jpg', $place->image_url());
        $this->assertEquals('http://example.com/centralpark', $place->url());
        $this->assertInstanceOf(PostalAddress::class, $place->address());
        $this->assertEquals('59th to 110th St', $place->address()->streetAddress());
        $this->assertEquals('New York', $place->address()->addressLocality());
        $this->assertEquals('NY', $place->address()->addressRegion());
        $this->assertEquals('10022', $place->address()->postalCode());
        $this->assertEquals('USA', $place->address()->addressCountry());
    }
}
