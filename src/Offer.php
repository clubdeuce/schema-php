<?php

namespace Clubdeuce\Schema;

/**
 * Class Offer
 *
 * @link https://schema.org/Offer
 */
class Offer extends Base
{
    protected float $_price = 0;

    protected string $_priceCurrency = 'USD';

    /**
     * @link https://schema.org/price
     */
    public function setPrice(float $price): void
    {
        $this->_price = $price;
    }

    /**
     * @link https://schema.org/priceCurrency
     */
    public function setPriceCurrency(string $currency): void
    {
        $this->_priceCurrency = $currency;
    }

    public function schema(): array
    {
        $schema = array(
            '@type'         => 'Offer',
            'price'         => $this->_price,
            'priceCurrency' => $this->_priceCurrency
        );

        return array_filter(array_merge(parent::schema(), $schema));
    }

}
