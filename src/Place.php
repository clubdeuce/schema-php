<?php

namespace Clubdeuce\Schema;

/**
 * @link https://schema.org/Place
 */
class Place extends Thing
{
    protected PostalAddress $_address;

    public function schema(): array
    {
        $schema = array_merge(parent::schema(), array(
            '@type' => 'Place',
            'address' => $this->_address?->schema(),
        ));

        return array_filter($schema);
    }

    public function setAddress(PostalAddress $address): void
    {
        $this->_address = $address;
    }
}
