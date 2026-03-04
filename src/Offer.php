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
    public function setPrice(float $price): static
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @link https://schema.org/priceCurrency
     */
    public function setPriceCurrency(string $currency): static
    {
        $this->priceCurrency = $currency;
        return $this;
    }

    public function schema(): array
    {
        $schema = [
            '@type'         => 'Offer',
            'price'         => $this->price,
            'priceCurrency' => $this->priceCurrency
        ];

        return array_filter(array_merge(parent::schema(), $schema), fn($v) => $v !== null && $v !== '');
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
