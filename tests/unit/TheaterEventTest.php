<?php

namespace Clubdeuce\Schema\tests\unit;

use Clubdeuce\Schema\CreativeWork;
use Clubdeuce\Schema\Offer;
use Clubdeuce\Schema\Person;
use Clubdeuce\Schema\TheaterEvent;
use Clubdeuce\Schema\Tests\testCase;
use DateTime;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(TheaterEvent::class)]
#[UsesClass(CreativeWork::class)]
#[UsesClass(Person::class)]
#[UsesClass(Offer::class)]
class TheaterEventTest extends testCase
{
    public function testSchemaHasCorrectType(): void
    {
        $event  = new TheaterEvent();
        $schema = $event->schema();

        $this->assertIsArray($schema);
        $this->assertArrayHasKey('@type', $schema);
        $this->assertEquals('TheaterEvent', $schema['@type']);
    }

    public function testWorkPerformedAbsentFromSchemaWhenNotSet(): void
    {
        $schema = (new TheaterEvent())->schema();
        $this->assertArrayNotHasKey('workPerformed', $schema);
    }

    public function testSchemaWithSingleWorkPerformed(): void
    {
        $play  = new CreativeWork(['name' => 'Hamlet']);
        $event = new TheaterEvent();
        $event->addWorkPerformed($play);

        $schema = $event->schema();

        $this->assertArrayHasKey('workPerformed', $schema);
        $this->assertCount(1, $schema['workPerformed']);
        $this->assertEquals('Hamlet', $schema['workPerformed'][0]['name']);
        $this->assertEquals('CreativeWork', $schema['workPerformed'][0]['@type']);
    }

    public function testSchemaWithMultipleWorksPerformed(): void
    {
        // e.g. a one-act festival evening, or a symphony program with several pieces
        $playOne = new CreativeWork(['name' => 'Trifles']);
        $playTwo = new CreativeWork(['name' => 'The Stronger']);

        $event = new TheaterEvent();
        $event->addWorkPerformed($playOne);
        $event->addWorkPerformed($playTwo);

        $schema = $event->schema();

        $this->assertCount(2, $schema['workPerformed']);
        $this->assertEquals('Trifles', $schema['workPerformed'][0]['name']);
        $this->assertEquals('The Stronger', $schema['workPerformed'][1]['name']);
    }

    public function testGetWorksPerformedReturnsAddedWorks(): void
    {
        $play  = new CreativeWork(['name' => 'Macbeth']);
        $event = new TheaterEvent();
        $event->addWorkPerformed($play);

        $this->assertCount(1, $event->worksPerformed());
        $this->assertSame($play, $event->worksPerformed()[0]);
    }

    public function testSetWorksPerformedReplacesPreviousWorks(): void
    {
        $a     = new CreativeWork(['name' => 'A']);
        $b     = new CreativeWork(['name' => 'B']);
        $event = new TheaterEvent();
        $event->addWorkPerformed($a);
        $event->setWorksPerformed([$b]);

        $this->assertCount(1, $event->worksPerformed());
        $this->assertSame($b, $event->worksPerformed()[0]);
    }

    public function testInheritsEventBehaviorLikeSubEvents(): void
    {
        $matinee = new TheaterEvent();
        $matinee->setStartDate(new DateTime('2026-06-01T14:00:00'));

        $event = new TheaterEvent();
        $event->addSubEvent($matinee);

        $schema = $event->schema();

        $this->assertArrayHasKey('subEvents', $schema);
        $this->assertEquals('TheaterEvent', $schema['subEvents'][0]['@type']);
    }

    public function testFluentMethodsReturnSameInstance(): void
    {
        $event = new TheaterEvent();

        $this->assertSame($event, $event->addWorkPerformed(new CreativeWork()));
        $this->assertSame($event, $event->setWorksPerformed([]));
    }
}
