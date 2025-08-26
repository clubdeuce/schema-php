<?php

namespace Clubdeuce\Schema;

/**
 * Represents an organizational entity extending the Base class.
 *
 * @link https://schema.org/Organization
 */
class Organization extends Thing
{
    protected ?PostalAddress $_address = null;
    protected string $_telephone = '';

    public function address(): ?PostalAddress
    {
        return $this->_address;
    }

    public function schema(): array
    {
        $schema = array_merge(parent::schema(), array(
            '@type'     => 'Organization',
            'address'   => $this->address()?->schema(),
            'telephone' => $this->telephone(),
        ));

        return $schema;
    }

    public function telephone(): string
    {
        return $this->_telephone;
    }
}
