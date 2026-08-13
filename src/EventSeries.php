<?php

namespace Clubdeuce\Schema;

/**
 * @link https://schema.org/EventSeries
 */
class EventSeries extends Event {

    /**
     * @return string[]
     */
    public function schema(): array {

        return array_filter( array_merge( parent::schema(), [
            '@type' => 'EventSeries',
        ] ) );

    }
}
