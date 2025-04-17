<?php
namespace Clubdeuce\Schema\tests\unit;

use Clubdeuce\Schema\Person;
use Clubdeuce\Schema\Tests\testCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Person::class)]
class PersonTest extends testCase
{
    public function testSchema()
    {
        $person = new Person();
        $schema = $person->schema();

        $this->assertIsArray($schema);
        $this->assertArrayHasKey('@type', $schema);
        $this->assertEquals('Person', $schema['@type']);
    }
}