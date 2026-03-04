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

    // --- Getter tests ---

    public function testGetDirectorsReturnsAddedDirectors(): void
    {
        $person = new Person(['name' => 'Director One']);
        $event  = new Event();
        $event->addDirector($person);

        $this->assertCount(1, $event->getDirectors());
        $this->assertSame($person, $event->getDirectors()[0]);
    }

    public function testGetDoorTimeReturnsNullByDefault(): void
    {
        $this->assertNull((new Event())->getDoorTime());
    }

    public function testGetDoorTimeReturnsSetValue(): void
    {
        $dt    = new DateTime('2025-06-01T18:00:00');
        $event = new Event();
        $event->setDoorTime($dt);

        $this->assertSame($dt, $event->getDoorTime());
    }

    public function testGetDurationReturnsNullByDefault(): void
    {
        $this->assertNull((new Event())->getDuration());
    }

    public function testGetDurationReturnsSetValue(): void
    {
        $interval = new DateInterval('PT2H');
        $event    = new Event();
        $event->setDuration($interval);

        $this->assertSame($interval, $event->getDuration());
    }

    public function testGetEndDateReturnsNullByDefault(): void
    {
        $this->assertNull((new Event())->getEndDate());
    }

    public function testGetEndDateReturnsSetValue(): void
    {
        $dt    = new DateTime('2025-06-01T22:00:00');
        $event = new Event();
        $event->setEndDate($dt);

        $this->assertSame($dt, $event->getEndDate());
    }

    public function testGetEventStatusDefaultIsEventScheduled(): void
    {
        $this->assertEquals('EventScheduled', (new Event())->getEventStatus());
    }

    public function testGetEventStatusReturnsSetValue(): void
    {
        $event = new Event();
        $event->setEventStatus('EventCancelled');

        $this->assertEquals('EventCancelled', $event->getEventStatus());
    }

    public function testGetOffersReturnsAddedOffers(): void
    {
        $offer = new Offer();
        $event = new Event();
        $event->addOffer($offer);

        $this->assertCount(1, $event->getOffers());
        $this->assertSame($offer, $event->getOffers()[0]);
    }

    public function testGetPlaceReturnsNullByDefault(): void
    {
        $this->assertNull((new Event())->getPlace());
    }

    public function testGetPlaceReturnsSetValue(): void
    {
        $place = new Place(['name' => 'Concert Hall']);
        $event = new Event();
        $event->setPlace($place);

        $this->assertSame($place, $event->getPlace());
    }

    public function testGetPerformersReturnsAddedPerformers(): void
    {
        $person = new Person(['name' => 'Performer One']);
        $event  = new Event();
        $event->addPerformer($person);

        $this->assertCount(1, $event->getPerformers());
        $this->assertSame($person, $event->getPerformers()[0]);
    }

    public function testGetSponsorsReturnsAddedSponsors(): void
    {
        $org   = new Organization(['name' => 'Sponsor Inc']);
        $event = new Event();
        $event->addSponsor($org);

        $this->assertCount(1, $event->getSponsors());
        $this->assertSame($org, $event->getSponsors()[0]);
    }

    public function testGetOrganizersReturnsAddedOrganizers(): void
    {
        $org   = new Organization(['name' => 'Organizer LLC']);
        $event = new Event();
        $event->addOrganizer($org);

        $this->assertCount(1, $event->getOrganizers());
        $this->assertSame($org, $event->getOrganizers()[0]);
    }

    public function testStartDateReturnsNullByDefault(): void
    {
        $this->assertNull((new Event())->startDate());
    }

    public function testStartDateReturnsSetValue(): void
    {
        $dt    = new DateTime('2025-06-01T19:00:00');
        $event = new Event();
        $event->setStartDate($dt);

        $this->assertSame($dt, $event->startDate());
    }

    // --- Schema output tests for remaining fields ---

    public function testDoorTimeAppearsInSchema(): void
    {
        $dt    = new DateTime('2025-06-01T18:00:00+00:00');
        $event = new Event();
        $event->setDoorTime($dt);

        $schema = $event->schema();

        $this->assertArrayHasKey('doorTime', $schema);
        $this->assertStringContainsString('2025-06-01', $schema['doorTime']);
    }

    public function testLocationAppearsInSchemaWhenPlaceSet(): void
    {
        $place = new Place(['name' => 'The Venue']);
        $event = new Event();
        $event->setPlace($place);

        $schema = $event->schema();

        $this->assertArrayHasKey('location', $schema);
        $this->assertEquals('Place', $schema['location']['@type']);
    }

    public function testDurationAppearsInSchema(): void
    {
        $start    = new DateTime('2025-06-01T19:00:00');
        $duration = new DateInterval('PT2H30M');
        $event    = new Event();
        $event->setStartDate($start)->setDuration($duration);

        $schema = $event->schema();

        $this->assertArrayHasKey('duration', $schema);
        $this->assertIsString($schema['duration']);
    }

    public function testEventStatusAppearsInSchema(): void
    {
        $schema = (new Event())->schema();

        $this->assertArrayHasKey('eventStatus', $schema);
        $this->assertEquals('EventScheduled', $schema['eventStatus']);
    }

    public function testCustomEventStatusAppearsInSchema(): void
    {
        $event = new Event();
        $event->setEventStatus('EventPostponed');

        $this->assertEquals('EventPostponed', $event->schema()['eventStatus']);
    }

    public function testComputedEndDateIsExactlyStartDatePlusDuration(): void
    {
        $start    = new DateTime('2025-06-01T19:00:00+00:00');
        $duration = new DateInterval('PT3H');
        $event    = new Event();
        $event->setStartDate($start)->setDuration($duration);

        $schema = $event->schema();

        $expected = (clone $start)->add($duration)->format(DATE_ATOM);
        $this->assertEquals($expected, $schema['endDate']);
    }

    // --- Bulk setter tests ---

    public function testSetDirectorsReplacesPreviousDirectors(): void
    {
        $a = new Person(['name' => 'A']);
        $b = new Person(['name' => 'B']);
        $event = new Event();
        $event->addDirector($a);
        $event->setDirectors([$b]);

        $this->assertCount(1, $event->getDirectors());
        $this->assertSame($b, $event->getDirectors()[0]);
    }

    public function testSetPerformersReplacesPreviousPerformers(): void
    {
        $a = new Person(['name' => 'A']);
        $b = new Person(['name' => 'B']);
        $event = new Event();
        $event->addPerformer($a);
        $event->setPerformers([$b]);

        $this->assertCount(1, $event->getPerformers());
        $this->assertSame($b, $event->getPerformers()[0]);
    }

    public function testSetOrganizersReplacesPreviousOrganizers(): void
    {
        $a = new Organization(['name' => 'A']);
        $b = new Organization(['name' => 'B']);
        $event = new Event();
        $event->addOrganizer($a);
        $event->setOrganizers([$b]);

        $this->assertCount(1, $event->getOrganizers());
        $this->assertSame($b, $event->getOrganizers()[0]);
    }

    public function testSetSponsorsReplacesPreviousSponsors(): void
    {
        $a = new Organization(['name' => 'A']);
        $b = new Organization(['name' => 'B']);
        $event = new Event();
        $event->addSponsor($a);
        $event->setSponsors([$b]);

        $this->assertCount(1, $event->getSponsors());
        $this->assertSame($b, $event->getSponsors()[0]);
    }

    public function testSetOffersReplacesPreviousOffers(): void
    {
        $a = new Offer();
        $b = new Offer();
        $event = new Event();
        $event->addOffer($a);
        $event->setOffers([$b]);

        $this->assertCount(1, $event->getOffers());
        $this->assertSame($b, $event->getOffers()[0]);
    }

    // --- Fluent interface ---

    public function testFluentAddMethodsReturnSameInstance(): void
    {
        $event = new Event();

        $this->assertSame($event, $event->addDirector(new Person()));
        $this->assertSame($event, $event->addPerformer(new Person()));
        $this->assertSame($event, $event->addSponsor(new Organization()));
        $this->assertSame($event, $event->addOrganizer(new Organization()));
        $this->assertSame($event, $event->addOffer(new Offer()));
        $this->assertSame($event, $event->setDuration(new DateInterval('PT1H')));
    }

    public function testFluentSetMethodsReturnSameInstance(): void
    {
        $event = new Event();
        $dt    = new DateTime();

        $this->assertSame($event, $event->setStartDate($dt));
        $this->assertSame($event, $event->setEndDate($dt));
        $this->assertSame($event, $event->setDoorTime($dt));
        $this->assertSame($event, $event->setEventStatus('EventScheduled'));
        $this->assertSame($event, $event->setPlace(new Place()));
        $this->assertSame($event, $event->setDirectors([]));
        $this->assertSame($event, $event->setPerformers([]));
        $this->assertSame($event, $event->setOrganizers([]));
        $this->assertSame($event, $event->setSponsors([]));
        $this->assertSame($event, $event->setOffers([]));
    }

    // --- Organization as performer/organizer ---

    public function testOrganizationCanBeAddedAsPerformer(): void
    {
        $org   = new Organization(['name' => 'Orchestra']);
        $event = new Event();
        $event->addPerformer($org);

        $schema = $event->schema();

        $this->assertEquals('Organization', $schema['performers'][0]['@type']);
        $this->assertEquals('Orchestra', $schema['performers'][0]['name']);
    }

    public function testOrganizationCanBeAddedAsOrganizer(): void
    {
        $org   = new Organization(['name' => 'Promoter Co']);
        $event = new Event();
        $event->addOrganizer($org);

        $schema = $event->schema();

        $this->assertEquals('Organization', $schema['organizers'][0]['@type']);
    }
}
