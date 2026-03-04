<?php
namespace Clubdeuce\Schema\tests\unit;

use Clubdeuce\Schema\Offer;
use Clubdeuce\Schema\Tests\testCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Depends;

#[CoversClass(Offer::class)]
class OfferTest extends testCase
{
    protected Offer $offer;

    public function setUp(): void
    {
        $this->offer = new Offer();
    }

    public function testSchema() {
        $schema = $this->offer->schema();

        $this->assertArrayHasKey('priceCurrency', $schema);
        $this->assertEquals('USD', $schema['priceCurrency']);
    }

    #[Depends('testSchema')]
    public function testSetPrice()
    {
        $this->offer->setPrice(19.95);

        $schema = $this->offer->schema();
        $this->assertEquals(19.95, $schema['price']);
    }

    #[Depends('testSchema')]
    public function testSetCurrency()
    {
        $this->offer->setPriceCurrency('GBP');

        $schema = $this->offer->schema();
        $this->assertEquals('GBP', $schema['priceCurrency']);
    }

    public function testPriceGetter(): void
    {
        $this->assertEquals(0.0, $this->offer->price());
        $this->offer->setPrice(49.99);
        $this->assertEquals(49.99, $this->offer->price());
    }

    public function testPriceCurrencyGetter(): void
    {
        $this->assertEquals('USD', $this->offer->priceCurrency());
        $this->offer->setPriceCurrency('EUR');
        $this->assertEquals('EUR', $this->offer->priceCurrency());
    }

    public function testPriceZeroRemainsInSchema(): void
    {
        // price defaults to 0; array_filter must NOT remove it
        $schema = $this->offer->schema();
        $this->assertArrayHasKey('price', $schema);
        $this->assertSame(0.0, $schema['price']);
    }

    public function testSchemaTypeIsOffer(): void
    {
        $this->assertEquals('Offer', $this->offer->schema()['@type']);
    }

    public function testFluentSettersReturnSameInstance(): void
    {
        $this->assertSame($this->offer, $this->offer->setPrice(10.0));
        $this->assertSame($this->offer, $this->offer->setPriceCurrency('CAD'));
    }
}