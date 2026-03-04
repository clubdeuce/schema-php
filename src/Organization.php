<?php

namespace Clubdeuce\Schema;

/**
 * Represents an organizational entity extending the Base class.
 *
 * @link https://schema.org/Organization
 */
class Organization extends Thing
{
    protected ?PostalAddress $address = null;
    protected string $telephone = '';

    public function __construct(array $args = [])
    {
        parent::__construct(static::resolvePostalAddress($args));
    }

    public function address(): ?PostalAddress
    {
        return $this->address;
    }

    public function schema(): array
    {
        $schema = array_merge(parent::schema(), [
            '@type'     => 'Organization',
            'address'   => $this->address()?->schema(),
            'telephone' => $this->telephone(),
        ]);

        return array_filter($schema);
    }

    public function telephone(): string
    {
        return $this->telephone;
    }
}
