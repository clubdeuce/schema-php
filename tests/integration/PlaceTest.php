<?php
namespace Clubdeuce\Schema\Tests\Integration;

use Clubdeuce\Schema\Place;
use Clubdeuce\Schema\PostalAddress;
use Clubdeuce\Schema\Tests\testCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(Place::class)]
#[UsesClass(PostalAddress::class)]
class PlaceTest extends testCase
{
    public function testSchema()
    {
        $address = new PostalAddress();
        $address->setStreetAddress('123 Anywhere Street');
        $address->setAddressLocality('Somewhere');
        $address->setAddressRegion('NY');
        $address->setAddressCountry('US');

        $place = new Place();
        $place->setAddress($address);

        $schema = $place->schema();
        $this->assertIsArray($schema);
        $this->assertArrayHasKey('address', $schema);
        $this->assertIsArray($schema['address']);
        $this->assertArrayHasKey('streetAddress', $schema['address']);
        $this->assertArrayHasKey('addressLocality', $schema['address']);
        $this->assertArrayHasKey('addressRegion', $schema['address']);
        $this->assertArrayHasKey('addressCountry', $schema['address']);
    }
}