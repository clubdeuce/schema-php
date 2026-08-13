<?php

namespace Clubdeuce\Schema\tests\unit;

use Clubdeuce\Schema\Event;
use Clubdeuce\Schema\EventSeries;
use Clubdeuce\Schema\Tests\testCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(EventSeries::class)]
#[UsesClass(Event::class)]
class EventSeriesTest extends testCase
{
    public function testSchemaHasCorrectType(): void
    {
        $series = new EventSeries();
        $schema = $series->schema();

        $this->assertIsArray($schema);
        $this->assertArrayHasKey('@type', $schema);
        $this->assertEquals('EventSeries', $schema['@type']);
    }

    public function testSchemaWithSubEvents(): void
    {
        $production = new Event();
        $production->setName('Opening Night');

        $series = new EventSeries();
        $series->addSubEvent($production);

        $schema = $series->schema();

        $this->assertArrayHasKey('subEvents', $schema);
        $this->assertEquals('Opening Night', $schema['subEvents'][0]['name']);
        $this->assertEquals('Event', $schema['subEvents'][0]['@type']);
    }
}
