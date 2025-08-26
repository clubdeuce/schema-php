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
        if(isset($args['address']) && is_array($args['address'])) {
            $args['address'] = new PostalAddress($args['address']);
        }

        parent::__construct($args);
    }

    public function schema(): array
    {
        $schema = array_merge(parent::schema(), array(
            '@type' => 'Place',
            'address' => $this->address?->schema(),
        ));

        return array_filter($schema);
    }

    public function setAddress(PostalAddress $address): void
    {
        $this->address = $address;
    }

    public function address(): PostalAddress
    {
        return $this->address;
    }
}
