<?php
namespace Clubdeuce\Schema\tests\unit;

use Clubdeuce\Schema\Organization;
use Clubdeuce\Schema\PostalAddress;
use Clubdeuce\Schema\Tests\testCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(Organization::class)]
#[UsesClass(PostalAddress::class)]
class OrganizationTest extends testCase
{
    public function testSchema()
    {
        $org    = new Organization();
        $schema = $org->schema();

        $this->assertIsArray($schema);
        $this->assertArrayHasKey('@type', $schema);
        $this->assertEquals('Organization', $schema['@type']);
        $this->assertArrayNotHasKey('telephone', $schema);
        $this->assertArrayNotHasKey('address', $schema);
    }

    public function testTelephoneGetterReturnsEmptyStringByDefault(): void
    {
        $this->assertEquals('', (new Organization())->telephone());
    }

    public function testTelephoneGetterReturnsSetValue(): void
    {
        $org = new Organization(['telephone' => '555-1234']);
        $this->assertEquals('555-1234', $org->telephone());
    }

    public function testAddressGetterReturnsNullByDefault(): void
    {
        $this->assertNull((new Organization())->address());
    }

    public function testAddressGetterReturnsSetValue(): void
    {
        $address = new PostalAddress(['streetAddress' => '1 Main St']);
        $org     = new Organization(['address' => $address]);
        $this->assertSame($address, $org->address());
    }

    public function testSchemaWithTelephone(): void
    {
        $org    = new Organization(['telephone' => '800-555-0100']);
        $schema = $org->schema();

        $this->assertArrayHasKey('telephone', $schema);
        $this->assertEquals('800-555-0100', $schema['telephone']);
    }

    public function testSchemaWithAddress(): void
    {
        $address = new PostalAddress(['streetAddress' => '42 Answer Ave']);
        $org     = new Organization(['address' => $address]);
        $schema  = $org->schema();

        $this->assertArrayHasKey('address', $schema);
        $this->assertEquals('PostalAddress', $schema['address']['@type']);
        $this->assertEquals('42 Answer Ave', $schema['address']['streetAddress']);
    }

    public function testConstructorConvertsArrayAddressToPostalAddress(): void
    {
        $org = new Organization([
            'address' => ['streetAddress' => '99 Array Blvd', 'addressLocality' => 'Testville'],
        ]);

        $this->assertInstanceOf(PostalAddress::class, $org->address());
        $this->assertEquals('99 Array Blvd', $org->address()->streetAddress());
    }
}