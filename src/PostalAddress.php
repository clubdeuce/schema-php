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
    protected string $addressCountry = '';

    /**
     * City in the US
     */
    protected string $addressLocality = '';

    /**
     * State in the US
     */
    protected string $addressRegion = '';

    protected string $postalCode = '';

    protected string $streetAddress = '';

    public function schema(): array
    {
        $schema = array(
            '@type'           => 'PostalAddress',
            'addressCountry'  => $this->addressCountry,
            'addressLocality' => $this->addressLocality,
            'addressRegion'   => $this->addressRegion,
            'name'            => $this->name,
            'postalCode'      => $this->postalCode,
            'streetAddress'   => $this->streetAddress,
        );

        $schema = array_merge(parent::schema(), $schema);

        return array_filter($schema);
    }

    public function setStreetAddress(string $address) : void
    {
        $this->streetAddress = $address;
    }

    public function setAddressCountry(string $country): void
    {
        $this->addressCountry = $country;
    }

    public function setAddressLocality(string $locality): void
    {
        $this->addressLocality = $locality;
    }

    public function setAddressRegion(string $region): void
    {
        $this->addressRegion = $region;
    }

    public function setPostalCode(string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    public function streetAddress(): string
    {
        return $this->streetAddress;
    }

    public function addressCountry(): string
    {
        return $this->addressCountry;
    }

    public function addressLocality(): string
    {
        return $this->addressLocality;
    }

    public function addressRegion(): string
    {
        return $this->addressRegion;
    }

    public function postalCode(): string
    {
        return $this->postalCode;
    }
}
