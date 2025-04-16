<?php
namespace Clubdeuce\Schema\tests\unit;

use Clubdeuce\Schema\Organization;
use Clubdeuce\Schema\Tests\testCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Organization::class)]
class OrganizationTest extends testCase
{
    public function testSchema()
    {
        $org    = new Organization();
        $schema = $org->schema();

        $this->assertIsArray($schema);
        $this->assertArrayHasKey('@type', $schema);
        $this->assertArrayHasKey('telephone', $schema);
        $this->assertArrayHasKey('address', $schema);
        $this->assertEquals('Organization', $schema['@type']);
    }
}