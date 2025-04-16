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
}