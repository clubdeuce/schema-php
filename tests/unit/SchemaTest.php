<?php

namespace Clubdeuce\Schema\tests\unit;

use Clubdeuce\Schema\Offer;
use Clubdeuce\Schema\Person;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Clubdeuce\Schema\Schema;
use PHPUnit\Framework\Attributes\CoversClass;


#[UsesClass(Person::class)]
#[UsesClass(Offer::class)]
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
        $person = $schema->makePerson($data);

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

    public function testMakeMusicEventPassesDataToMusicEvent()
    {
        $data = [
            'name' => 'Jazz Night',
            'description' => 'A night of smooth jazz music',
            'image_url' => 'http://example.com/jazznight.jpg',
            'url' => 'http://example.com/jazznight',
        ];

        $schema = new Schema();
        $musicEvent = $schema->makeMusicEvent($data);

        $this->assertEquals('Jazz Night', $musicEvent->name());
        $this->assertEquals('A night of smooth jazz music', $musicEvent->description());
        $this->assertEquals('http://example.com/jazznight.jpg', $musicEvent->image_url());
        $this->assertEquals('http://example.com/jazznight', $musicEvent->url());
    }

    public function testMakeOfferPassesDataToOffer()
    {
        $data = [
            'name' => 'Special Discount Offer',
            'description' => 'An exclusive discount offer for a limited time',
            'image_url' => 'http://example.com/offer.jpg',
            'url' => 'http://example.com/offer',
            'price' => 99.99,
            'priceCurrency' => 'USD'
        ];

        $schema = new Schema();
        $offer = $schema->makeOffer($data);

        $this->assertEquals('Special Discount Offer', $offer->name());
        $this->assertEquals('An exclusive discount offer for a limited time', $offer->description());
        $this->assertEquals('http://example.com/offer.jpg', $offer->image_url());
        $this->assertEquals('http://example.com/offer', $offer->url());
        $this->assertEquals(99.99, $offer->price());
        $this->assertEquals('USD', $offer->priceCurrency());
    }


}
