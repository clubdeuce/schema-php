<?php

namespace Clubdeuce\Schema;

/**
 * Class Offer
 *
 * @link https://schema.org/Offer
 */
class Offer extends Thing
{
    protected float $price = 0;

    protected string $priceCurrency = 'USD';

    /**
     * @link https://schema.org/price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @link https://schema.org/priceCurrency
     */
    public function setPriceCurrency(string $currency): void
    {
        $this->priceCurrency = $currency;
    }

    public function schema(): array
    {
        $schema = array(
            '@type'         => 'Offer',
            'price'         => $this->price,
            'priceCurrency' => $this->priceCurrency
        );

        return array_filter(array_merge(parent::schema(), $schema));
    }

    public function price(): float
    {
        return $this->price;
    }

    public function priceCurrency(): string
    {
        return $this->priceCurrency;
    }

}
