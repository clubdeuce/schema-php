<?php

namespace Clubdeuce\Schema\tests\unit;

use Clubdeuce\Schema\CreativeWork;
use Clubdeuce\Schema\Person;
use Clubdeuce\Schema\Tests\testCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(CreativeWork::class)]
#[UsesClass(Person::class)]
class CreativeWorkTest extends testCase
{
    public function testSchemaHasCorrectType(): void
    {
        $work   = new CreativeWork();
        $schema = $work->schema();

        $this->assertIsArray($schema);
        $this->assertArrayHasKey('@type', $schema);
        $this->assertEquals('CreativeWork', $schema['@type']);
    }

    public function testAuthorAbsentFromSchemaWhenNotSet(): void
    {
        $schema = (new CreativeWork())->schema();
        $this->assertArrayNotHasKey('author', $schema);
    }

    public function testSchemaWithAuthors(): void
    {
        $author = new Person(['name' => 'William Shakespeare']);
        $work   = new CreativeWork();
        $work->addAuthor($author);

        $schema = $work->schema();

        $this->assertArrayHasKey('author', $schema);
        $this->assertEquals('William Shakespeare', $schema['author'][0]['name']);
        $this->assertEquals('Person', $schema['author'][0]['@type']);
    }

    public function testGetAuthorsReturnsAddedAuthors(): void
    {
        $author = new Person(['name' => 'Author One']);
        $work   = new CreativeWork();
        $work->addAuthor($author);

        $this->assertCount(1, $work->authors());
        $this->assertSame($author, $work->authors()[0]);
    }

    public function testSetAuthorsReplacesPreviousAuthors(): void
    {
        $a    = new Person(['name' => 'A']);
        $b    = new Person(['name' => 'B']);
        $work = new CreativeWork();
        $work->addAuthor($a);
        $work->setAuthors([$b]);

        $this->assertCount(1, $work->authors());
        $this->assertSame($b, $work->authors()[0]);
    }

    public function testFluentMethodsReturnSameInstance(): void
    {
        $work = new CreativeWork();

        $this->assertSame($work, $work->addAuthor(new Person()));
        $this->assertSame($work, $work->setAuthors([]));
    }
}
