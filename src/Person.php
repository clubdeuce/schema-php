<?php
namespace Clubdeuce\Schema;

/**
 * @link https://schema.org/Person
 */
class Person extends Base {
    /**
     * @return array
     */
    function schema() : array {

        $schema = array_merge( parent::schema(), array(
            '@type' => 'Person',
        ) );

        return $schema;

    }

}