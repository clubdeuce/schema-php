<?php
namespace Clubdeuce\Schema\Tests\unit;

use Clubdeuce\Schema\MusicComposition;
use Clubdeuce\Schema\Person;
use Clubdeuce\Schema\Tests\testCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(MusicComposition::class)]
#[UsesClass(Person::class)]
class MusicalCompositionTest extends testCase
{
    public function testSchema() {
        $composition = new MusicComposition();
        $schema      = $composition->schema();

        $this->assertIsArray($schema);
        $this->assertArrayHasKey('@type', $schema);
        $this->assertEquals('MusicComposition', $schema['@type']);
        $this->assertArrayNotHasKey('musicCompositionForm', $schema);

        $composition->setForm('Sonata');
        $schema = $composition->schema();
        $this->assertArrayHasKey('musicCompositionForm', $schema);
        $this->assertEquals('Sonata', $schema['musicCompositionForm']);
    }

    public function testSchemaWithComposer(): void
    {
        $composer    = new Person(['name' => 'Bach']);
        $composition = new MusicComposition();
        $composition->setComposer($composer);

        $schema = $composition->schema();

        $this->assertArrayHasKey('composer', $schema);
        $this->assertEquals('Person', $schema['composer']['@type']);
        $this->assertEquals('Bach', $schema['composer']['name']);
    }

    public function testSchemaWithLyricist(): void
    {
        $lyricist    = new Person(['name' => 'Goethe']);
        $composition = new MusicComposition();
        $composition->setLyricist($lyricist);

        $schema = $composition->schema();

        $this->assertArrayHasKey('lyricist', $schema);
        $this->assertEquals('Goethe', $schema['lyricist']['name']);
    }

    public function testComposerAbsentFromSchemaWhenNotSet(): void
    {
        $schema = (new MusicComposition())->schema();
        $this->assertArrayNotHasKey('composer', $schema);
    }

    public function testLyricistAbsentFromSchemaWhenNotSet(): void
    {
        $schema = (new MusicComposition())->schema();
        $this->assertArrayNotHasKey('lyricist', $schema);
    }

    public function testFluentSettersReturnSameInstance(): void
    {
        $composition = new MusicComposition();
        $person      = new Person();

        $this->assertSame($composition, $composition->setForm('Sonata'));
        $this->assertSame($composition, $composition->setComposer($person));
        $this->assertSame($composition, $composition->setLyricist($person));
    }
}