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
}
