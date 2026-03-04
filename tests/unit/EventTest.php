<?php

namespace Clubdeuce\Schema\tests\unit;

use Clubdeuce\Schema\Event;
use Clubdeuce\Schema\Offer;
use Clubdeuce\Schema\Organization;
use Clubdeuce\Schema\Person;
use Clubdeuce\Schema\Place;
use Clubdeuce\Schema\Tests\testCase;
use DateTime;
use DateInterval;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(Event::class)]
#[UsesClass(Person::class)]
#[UsesClass(Organization::class)]
#[UsesClass(Offer::class)]
#[UsesClass(Place::class)]
class EventTest extends testCase
{
    public function testSchemaHasCorrectType(): void
    {
        $event  = new Event();
        $schema = $event->schema();

        $this->assertIsArray($schema);
        $this->assertArrayHasKey('@type', $schema);
        $this->assertEquals('Event', $schema['@type']);
    }

    public function testSchemaWithPerformersDirectorsSponsorsOffers(): void
    {
        $director  = new Person();
        $director->setName('Jane Director');
        $performer = new Person();
        $performer->setName('Joe Performer');
        $sponsor   = new Organization();
        $sponsor->setName('Acme Corp');
        $offer     = new Offer();
        $offer->setPrice(25.00);

        $event = new Event();
        $event->addDirector($director);
        $event->addPerformer($performer);
        $event->addSponsor($sponsor);
        $event->addOffer($offer);

        $schema = $event->schema();

        $this->assertArrayHasKey('directors', $schema);
        $this->assertArrayHasKey('performers', $schema);
        $this->assertArrayHasKey('sponsors', $schema);
        $this->assertArrayHasKey('offers', $schema);
        $this->assertEquals('Jane Director', $schema['directors'][0]['name']);
        $this->assertEquals('Joe Performer', $schema['performers'][0]['name']);
        $this->assertEquals('Acme Corp', $schema['sponsors'][0]['name']);
        $this->assertEquals(25.00, $schema['offers'][0]['price']);
    }

    public function testSchemaWithOrganizers(): void
    {
        $organizer = new Person();
        $organizer->setName('Sally Organizer');

        $event = new Event();
        $event->addOrganizer($organizer);

        $schema = $event->schema();

        $this->assertArrayHasKey('organizers', $schema);
        $this->assertEquals('Sally Organizer', $schema['organizers'][0]['name']);
    }

    public function testSchemaWithStartAndEndDate(): void
    {
        $start = new DateTime('2025-06-01T19:00:00');
        $end   = new DateTime('2025-06-01T22:00:00');

        $event = new Event();
        $event->setStartDate($start);
        $event->setEndDate($end);

        $schema = $event->schema();

        $this->assertArrayHasKey('startDate', $schema);
        $this->assertArrayHasKey('endDate', $schema);
    }

    public function testEndDateComputedFromStartDateAndDuration(): void
    {
        $start    = new DateTime('2025-06-01T19:00:00');
        $duration = new DateInterval('PT3H');

        $event = new Event();
        $event->setStartDate($start);
        $event->setDuration($duration);

        $schema = $event->schema();

        $this->assertArrayHasKey('endDate', $schema);
        $this->assertStringContainsString('2025-06-01', $schema['endDate']);
    }

    public function testEmptyPropertiesNotInSchema(): void
    {
        $event  = new Event();
        $schema = $event->schema();

        $this->assertArrayNotHasKey('doorTime', $schema);
        $this->assertArrayNotHasKey('endDate', $schema);
        $this->assertArrayNotHasKey('duration', $schema);
        $this->assertArrayNotHasKey('startDate', $schema);
        $this->assertArrayNotHasKey('location', $schema);
    }
}
