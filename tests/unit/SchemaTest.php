<?php
use PHPUnit\Framework\TestCase;
use Clubdeuce\Schema\Schema;
use Clubdeuce\Schema\Person;

class SchemaTest extends TestCase
{
    public function testMakePersonReturnsPersonInstance()
    {
        $schema = new Schema();
        $person = $schema->make_person();

        $this->assertInstanceOf(Person::class, $person);
    }

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
