<?php

namespace Clubdeuce\Schema;

/**
 * Represents an organizational entity extending the Base class.
 *
 * @link https://schema.org/Organization
 *
 * @method PostalAddress|null address()
 * @method string             telephone()
 */
class Organization extends Thing
{
    protected ?PostalAddress $_address = null;
    protected string $_telephone = '';

    /**
     * @return array
     */
    function schema(): array
    {
        $schema = array_merge(parent::schema(), array(
            '@type'     => 'Organization',
            'address'   => $this->address() ? $this->address()->schema() : null,
            'telephone' => $this->telephone(),
        ));

        return $schema;
    }
}
