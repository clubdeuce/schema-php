<?php
namespace Clubdeuce\Schema\tests\unit;

use Clubdeuce\Schema\Tests\testCase;
use Clubdeuce\Schema\Thing;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Thing::class)]
class ThingTest extends testCase
{
    /**
     * @covers ::_set_state
     * @return void
     */
    public function testSetStateUpdatesProperties()
    {
        $thing = new Thing([
            'name'        => 'Updated Name',
            'description' => 'Updated Description',
            'url'         => 'https://updated-url.com',
            'image_url'   => 'https://updated-url.com/image.jpg',
        ]);

        $this->assertEquals('Updated Name', $thing->name());
        $this->assertEquals('Updated Description', $thing->description());
        $this->assertEquals('https://updated-url.com', $thing->url());
        $this->assertEquals('https://updated-url.com/image.jpg', $thing->image_url());
    }

    /**
     * @covers ::_set_state
     * @return void
     * @throws \ReflectionException
     */
    public function testSetStateHandlesExtraArgs()
    {
        $thing = new Thing([
            'unknown_property' => 'Extra Value',
        ]);

        $getExtraArgs = (new \ReflectionClass(Thing::class))->getProperty('_extra_args');
        $getExtraArgs->setAccessible(true);

        $extraArgs = $getExtraArgs->getValue($thing);

        $this->assertArrayHasKey('unknown_property', $extraArgs);
        $this->assertEquals('Extra Value', $extraArgs['unknown_property']);
    }

    /**
     * @covers ::__call
     */
    public function testSetValidProperties()
    {
        $thing = new Thing();
        $thing->set_name('Test Name');
        $thing->set_description('Test Description');
        $thing->set_url('https://test.com');
        $thing->set_image_url('https://test.com/image.jpg');

        $this->assertEquals('Test Name', $thing->name());
        $this->assertEquals('Test Description', $thing->description());
        $this->assertEquals('https://test.com', $thing->url());
        $this->assertEquals('https://test.com/image.jpg', $thing->image_url());
    }

    /**
     * @covers ::__call
     */
    public function testGetValidProperties()
    {
        $thing = new Thing();
        $thing->set_name('Test Name');

        $this->assertEquals('Test Name', $thing->name());
        $this->assertEquals('', $thing->description());
        $this->assertEquals('', $thing->url());
        $this->assertEquals('', $thing->image_url());
    }

    /**
     * @covers ::schema
     * @return void
     */
    public function testSchema() {
        $base = new Thing();
        $schema = $base->schema();

        $this->assertIsArray($schema);
        $this->assertArrayHasKey('@context', $schema);
        $this->assertArrayHasKey('@type', $schema);
    }

    /**
     * @covers ::ldjson
     * @return void
     */
    public function testLdJsonWithEmptyThing()
    {
        $thing = new Thing();
        $result = $thing->ldJson();
        
        $this->assertIsString($result);
        $this->assertStringStartsWith('<script type="application/ld+json">', $result);
        $this->assertStringEndsWith('</script>', $result);
        
        // Extract JSON from script tag
        $json = $this->extractJsonFromScript($result);
        $decoded = json_decode($json, true);
        
        $this->assertIsArray($decoded);
        $this->assertEquals('https://schema.org', $decoded['@context']);
        $this->assertEquals('Thing', $decoded['@type']);
        
        // Empty properties should be filtered out
        $this->assertArrayNotHasKey('description', $decoded);
        $this->assertArrayNotHasKey('image', $decoded);
        $this->assertArrayNotHasKey('name', $decoded);
        $this->assertArrayNotHasKey('url', $decoded);
    }

    /**
     * @covers ::ldjson
     * @return void
     */
    public function testLdJsonWithAllProperties()
    {
        $thing = new Thing();
        $thing->set_name('Test Thing');
        $thing->set_description('A test description');
        $thing->set_url('https://example.com');
        $thing->set_image_url('https://example.com/image.jpg');
        
        $result = $thing->ldJson();
        
        $this->assertIsString($result);
        $this->assertStringStartsWith('<script type="application/ld+json">', $result);
        $this->assertStringEndsWith('</script>', $result);
        
        $json = $this->extractJsonFromScript($result);
        $decoded = json_decode($json, true);
        
        $this->assertIsArray($decoded);
        $this->assertEquals('https://schema.org', $decoded['@context']);
        $this->assertEquals('Thing', $decoded['@type']);
        $this->assertEquals('Test Thing', $decoded['name']);
        $this->assertEquals('A test description', $decoded['description']);
        $this->assertEquals('https://example.com', $decoded['url']);
        $this->assertEquals('https://example.com/image.jpg', $decoded['image']);
    }

    /**
     * @covers ::ldjson
     * @return void
     */
    public function testLdJsonWithPartialProperties()
    {
        $thing = new Thing();
        $thing->set_name('Partial Thing');
        $thing->set_url('https://example.com');
        
        $result = $thing->ldJson();
        
        $json = $this->extractJsonFromScript($result);
        $decoded = json_decode($json, true);
        
        $this->assertIsArray($decoded);
        $this->assertEquals('https://schema.org', $decoded['@context']);
        $this->assertEquals('Thing', $decoded['@type']);
        $this->assertEquals('Partial Thing', $decoded['name']);
        $this->assertEquals('https://example.com', $decoded['url']);
        
        // Empty properties should be filtered out
        $this->assertArrayNotHasKey('description', $decoded);
        $this->assertArrayNotHasKey('image', $decoded);
    }

    /**
     * @covers ::ldjson
     * @return void
     */
    public function testLdJsonReturnsValidJson()
    {
        $thing = new Thing();
        $thing->set_name('JSON Test');
        $thing->set_description('Testing JSON validity');
        
        $result = $thing->ldJson();
        $json = $this->extractJsonFromScript($result);
        
        // Test that JSON is valid
        $decoded = json_decode($json, true);
        $this->assertNotNull($decoded);
        $this->assertEquals(JSON_ERROR_NONE, json_last_error());
        
        // Test that we can encode it back
        $reencoded = json_encode($decoded);
        $this->assertIsString($reencoded);
    }

    /**
     * @covers ::ldjson
     * @return void
     */
    public function testLdJsonHandlesSpecialCharacters()
    {
        $thing = new Thing();
        $thing->set_name('Special "Quotes" & Ampersands');
        $thing->set_description('Description with <html> tags & "quotes"');
        
        $result = $thing->ldJson();
        $json = $this->extractJsonFromScript($result);
        $decoded = json_decode($json, true);
        
        $this->assertEquals('Special "Quotes" & Ampersands', $decoded['name']);
        $this->assertEquals('Description with <html> tags & "quotes"', $decoded['description']);
    }


    
    /**
     * Helper method to extract JSON content from script tag
     */
    /**
     * Helper method to extract JSON content from script tag
     */
    private function extractJsonFromScript(string $scriptTag): string
    {
        preg_match('/<script type="application\/ld\+json">(.*?)<\/script>/', $scriptTag, $matches);
        return $matches[1] ?? '';
    }
    
    
}