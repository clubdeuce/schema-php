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

    public function testSchemaContainsThingFields(): void
    {
        $person = new Person(['name' => 'Jane Doe', 'description' => 'A person']);
        $schema = $person->schema();

        $this->assertEquals('Jane Doe', $schema['name']);
        $this->assertEquals('A person', $schema['description']);
    }

    public function testEmptyPersonSchemaHasNoExtraKeys(): void
    {
        $schema = (new Person())->schema();

        $this->assertArrayNotHasKey('name', $schema);
        $this->assertArrayNotHasKey('description', $schema);
    }

    public function testFluentSettersReturnPersonInstance(): void
    {
        $person = new Person();
        $this->assertSame($person, $person->setName('John'));
        $this->assertSame($person, $person->setDescription('A desc'));
        $this->assertSame($person, $person->setUrl('https://example.com'));
        $this->assertSame($person, $person->setImageUrl('https://example.com/img.jpg'));
    }
}