<?php

namespace Clubdeuce\Schema;

/**
 * Class PostalAddress
 * @package DSO\Modules\Schema
 *
 * @link https://schema.org/PostalAddress
 */
class PostalAddress extends Thing
{
    protected string $_addressCountry = '';

    /**
     * City in the US
     */
    protected string $_addressLocality = '';

    /**
     * State in the US
     */
    protected string $_addressRegion = '';

    protected string $_postalCode = '';

    protected string $_streetAddress = '';

    public function schema(): array
    {
        $schema = array(
            '@type'           => 'PostalAddress',
            'addressCountry'  => $this->_addressCountry,
            'addressLocality' => $this->_addressLocality,
            'addressRegion'   => $this->_addressRegion,
            'name'            => $this->name,
            'postalCode'      => $this->_postalCode,
            'streetAddress'   => $this->_streetAddress,
        );

        $schema = array_merge(parent::schema(), $schema);

        return array_filter($schema);
    }

    public function setStreetAddress(string $address) : void
    {
        $this->_streetAddress = $address;
    }

    public function setAddressCountry(string $country): void
    {
        $this->_addressCountry = $country;
    }

    public function setAddressLocality(string $locality): void
    {
        $this->_addressLocality = $locality;
    }

    public function setAddressRegion(string $region): void
    {
        $this->_addressRegion = $region;
    }

    public function setPostalCode(string $postalCode): void
    {
        $this->_postalCode = $postalCode;
    }

    public function streetAddress(): string
    {
        return $this->_streetAddress;
    }

    public function country(): string
    {
        return $this->_addressCountry;
    }

    public function locality(): string
    {
        return $this->_addressLocality;
    }

    public function region(): string
    {
        return $this->_addressRegion;
    }

    public function postalCode(): string
    {
        return $this->_postalCode;
    }
}
