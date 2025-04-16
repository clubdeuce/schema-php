<?php
namespace Clubdeuce\Schema\tests\unit;

use Clubdeuce\Schema\Base;
use Clubdeuce\Schema\Tests\testCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Base::class)]
class BaseTest extends testCase
{
    public function testSchema() {
        $base = new Base();
        $schema = $base->schema();

        $this->assertIsArray($schema);
        $this->assertArrayHasKey('@context', $schema);
        $this->assertArrayHasKey('@type', $schema);
    }
}
