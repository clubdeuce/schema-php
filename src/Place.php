<?php

namespace Clubdeuce\Schema;

/**
 * @link https://schema.org/Place
 */
class Place extends Thing
{
    protected PostalAddress|null $address = null;

    public function __construct(array $args = [])
    {
        parent::__construct(static::resolvePostalAddress($args));
    }

    public function schema(): array
    {
        $schema = array_merge(parent::schema(), [
            '@type' => 'Place',
            'address' => $this->address?->schema(),
        ]);

        return array_filter($schema);
    }

    public function setAddress(PostalAddress $address): static
    {
        $this->address = $address;
        return $this;
    }

    public function address(): ?PostalAddress
    {
        return $this->address;
    }
}
