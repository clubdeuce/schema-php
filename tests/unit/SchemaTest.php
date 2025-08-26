<?php

namespace Clubdeuce\Schema\tests\unit;

use Clubdeuce\Schema\Person;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Clubdeuce\Schema\Schema;
use PHPUnit\Framework\Attributes\CoversClass;


#[UsesClass(Person::class)]
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
        $person = $schema->make_person($data);

        $this->assertEquals('John Doe', $person->name());
        $this->assertEquals('A test person', $person->description());
        $this->assertEquals('http://example.com/image.jpg', $person->image_url());
    }
}
