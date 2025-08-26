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
        if(isset($args['address']) && is_array($args['address'])) {
            $args['address'] = new PostalAddress($args['address']);
        }

        parent::__construct($args);
    }

    public function address(): ?PostalAddress
    {
        return $this->address;
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
        return $this->telephone;
    }
}
