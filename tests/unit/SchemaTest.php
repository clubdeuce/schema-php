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

    public function testMakeMusicCompositionPassesDataToMusicComposition()
    {
        $data = [
            'name' => 'Symphony No. 5',
            'description' => 'A famous symphony composed by Beethoven',
            'image_url' => 'http://example.com/symphony.jpg',
            'url' => 'http://example.com/symphony',
        ];

        $schema = new Schema();
        $composition = $schema->makeMusicComposition($data);

        $this->assertEquals('Symphony No. 5', $composition->name());
        $this->assertEquals('A famous symphony composed by Beethoven', $composition->description());
        $this->assertEquals('http://example.com/symphony.jpg', $composition->image_url());
        $this->assertEquals('http://example.com/symphony', $composition->url());
    }
}
