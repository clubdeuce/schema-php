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

    public function testSchemaTypeIsPlace(): void
    {
        $this->assertEquals('Place', (new Place())->schema()['@type']);
    }

    public function testAddressGetterReturnsNullByDefault(): void
    {
        $this->assertNull((new Place())->address());
    }

    public function testAddressGetterReturnsSetValue(): void
    {
        $address = new PostalAddress(['streetAddress' => '1 Test St']);
        $place   = new Place();
        $place->setAddress($address);

        $this->assertSame($address, $place->address());
    }

    public function testSchemaWithoutAddressHasNoAddressKey(): void
    {
        $schema = (new Place())->schema();
        $this->assertArrayNotHasKey('address', $schema);
    }

    public function testConstructorWithArrayAddressCreatesPostalAddress(): void
    {
        $place = new Place([
            'address' => ['streetAddress' => '5 Array Lane', 'addressLocality' => 'Testburg'],
        ]);

        $this->assertInstanceOf(PostalAddress::class, $place->address());
        $this->assertEquals('5 Array Lane', $place->address()->streetAddress());
    }

    public function testFluentSetAddressReturnsSameInstance(): void
    {
        $place   = new Place();
        $address = new PostalAddress();
        $this->assertSame($place, $place->setAddress($address));
    }
}