<?php
namespace Clubdeuce\Schema\Tests\Integration;

use Clubdeuce\Schema\PostalAddress;
use Clubdeuce\Schema\Tests\testCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(PostalAddress::class)]
class PostalAddressTest extends testCase
{
    public function testSchema()
    {
        $address = new PostalAddress();

        $address->setStreetAddress('1 Avenue of the Americas');
        $address->setAddressLocality('New York');
        $address->setAddressRegion('NY');
        $address->setAddressCountry('US');
        $address->setPostalCode('10001');

        $schema  = $address->schema();

        $this->assertIsArray($schema);
        $this->assertArrayHasKey('@type', $schema);
        $this->assertArrayHasKey('streetAddress', $schema);
        $this->assertArrayHasKey('addressLocality', $schema);
        $this->assertArrayHasKey('addressRegion', $schema);
        $this->assertArrayHasKey('addressCountry', $schema);
        $this->assertEquals('PostalAddress', $schema['@type']);
        $this->assertEquals('1 Avenue of the Americas', $schema['streetAddress']);
        $this->assertEquals('New York', $schema['addressLocality']);
        $this->assertEquals('NY', $schema['addressRegion']);
        $this->assertEquals('10001', $schema['postalCode']);
    }

    public function testGetters(): void
    {
        $address = new PostalAddress();
        $address->setStreetAddress('10 Getter St');
        $address->setAddressLocality('Gettertown');
        $address->setAddressRegion('GT');
        $address->setAddressCountry('GX');
        $address->setPostalCode('99999');

        $this->assertEquals('10 Getter St', $address->streetAddress());
        $this->assertEquals('Gettertown', $address->addressLocality());
        $this->assertEquals('GT', $address->addressRegion());
        $this->assertEquals('GX', $address->addressCountry());
        $this->assertEquals('99999', $address->postalCode());
    }

    public function testEmptyAddressSchemaFiltersEmptyValues(): void
    {
        $schema = (new PostalAddress())->schema();

        $this->assertArrayNotHasKey('streetAddress', $schema);
        $this->assertArrayNotHasKey('addressLocality', $schema);
        $this->assertArrayNotHasKey('addressRegion', $schema);
        $this->assertArrayNotHasKey('addressCountry', $schema);
        $this->assertArrayNotHasKey('postalCode', $schema);
    }

    public function testFluentSettersReturnSameInstance(): void
    {
        $address = new PostalAddress();
        $this->assertSame($address, $address->setStreetAddress('1 St'));
        $this->assertSame($address, $address->setAddressLocality('City'));
        $this->assertSame($address, $address->setAddressRegion('ST'));
        $this->assertSame($address, $address->setAddressCountry('US'));
        $this->assertSame($address, $address->setPostalCode('12345'));
    }
}
