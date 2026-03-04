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
        $schema = [
            '@type'           => 'PostalAddress',
            'addressCountry'  => $this->addressCountry,
            'addressLocality' => $this->addressLocality,
            'addressRegion'   => $this->addressRegion,
            'name'            => $this->name,
            'postalCode'      => $this->postalCode,
            'streetAddress'   => $this->streetAddress,
        ];

        $schema = array_merge(parent::schema(), $schema);

        return array_filter($schema);
    }

    public function setStreetAddress(string $address) : static
    {
        $this->streetAddress = $address;
        return $this;
    }

    public function setAddressCountry(string $country): static
    {
        $this->addressCountry = $country;
        return $this;
    }

    public function setAddressLocality(string $locality): static
    {
        $this->addressLocality = $locality;
        return $this;
    }

    public function setAddressRegion(string $region): static
    {
        $this->addressRegion = $region;
        return $this;
    }

    public function setPostalCode(string $postalCode): static
    {
        $this->postalCode = $postalCode;
        return $this;
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
