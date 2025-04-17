<?php
namespace Clubdeuce\Schema\tests\unit;

use Clubdeuce\Schema\Person;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Person::class)]
class PersonTest extends BaseTest
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