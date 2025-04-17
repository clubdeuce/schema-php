<?php
namespace Clubdeuce\Schema\tests\Integration;

use Clubdeuce\Schema\MusicEvent;
use Clubdeuce\Schema\Offer;
use Clubdeuce\Schema\Organization;
use Clubdeuce\Schema\Person;
use Clubdeuce\Schema\Tests\testCase;
use DateTime;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(MusicEvent::class)]
#[UsesClass(Person::class)]
#[UsesClass(Organization::class)]
#[UsesClass(Offer::class)]
class MusicEventTest extends testCase
{
    public function testSchema()
    {
        $composer = new Person();
        $composer->set_name('Joseph Doe');
        $director = new Person();
        $director->set_name('John Doe');
        $performer = new Person();
        $performer->set_name('Jane Doe');
        $sponsor = new Organization();
        $sponsor->set_name('Acme, Inc');
        $offer = new Offer();
        $offer->setPrice(19.95);

        $event  = new MusicEvent();
        $event->addComposer($composer);
        $event->addDirector($director);
        $event->addPerformer($performer);
        $event->addSponsor($sponsor);
        $event->addOffer($offer);

        $schema = $event->schema();

        $this->assertIsArray($schema);
        $this->assertArrayHasKey('@type', $schema);
        $this->assertEquals('MusicEvent', $schema['@type']);
        $this->assertArrayHasKey('composers', $schema);
        $this->assertArrayHasKey('directors', $schema);
        $this->assertArrayHasKey('performers', $schema);
        $this->assertArrayHasKey('sponsors', $schema);
        $this->assertArrayHasKey('offers', $schema);
        $this->assertIsArray($schema['composers']);
        $this->assertIsArray($schema['directors']);
        $this->assertIsArray($schema['performers']);
        $this->assertIsArray($schema['sponsors']);
        $this->assertIsArray($schema['offers']);
        $this->assertIsArray($schema['composers'][0]);
        $this->assertIsArray($schema['directors'][0]);
        $this->assertIsArray($schema['performers'][0]);
        $this->assertIsArray($schema['sponsors'][0]);
        $this->assertIsArray($schema['offers'][0]);
        $this->assertEquals('Joseph Doe', $schema['composers'][0]['name']);
        $this->assertEquals('John Doe', $schema['directors'][0]['name']);
        $this->assertEquals('Jane Doe', $schema['performers'][0]['name']);
        $this->assertEquals('Acme, Inc', $schema['sponsors'][0]['name']);
        $this->assertEquals(19.95, $schema['offers'][0]['price']);
    }
}