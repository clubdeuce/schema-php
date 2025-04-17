<?php
namespace Clubdeuce\Schema\Tests\unit;

use Clubdeuce\Schema\MusicComposition;
use Clubdeuce\Schema\Tests\testCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(MusicComposition::class)]
class MusicalCompositionTest extends testCase
{
    public function testSchema() {
        $composition = new MusicComposition();
        $schema      = $composition->schema();

        $this->assertIsArray($schema);
        $this->assertArrayHasKey('@type', $schema);
        $this->assertArrayHasKey('musicCompositionForm', $schema);
        $this->assertEquals('MusicComposition', $schema['@type']);
    }
}