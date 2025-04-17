<?php
namespace Clubdeuce\Schema\tests\unit;

use Clubdeuce\Schema\Thing;
use Clubdeuce\Schema\Tests\testCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Thing::class)]
class ThingTest extends testCase
{
    public function testSchema() {
        $base = new Thing();
        $schema = $base->schema();

        $this->assertIsArray($schema);
        $this->assertArrayHasKey('@context', $schema);
        $this->assertArrayHasKey('@type', $schema);
    }
}
