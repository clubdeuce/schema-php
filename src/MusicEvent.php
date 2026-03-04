<?php

namespace Clubdeuce\Schema;

/**
 * @link https://schema.org/MusicEvent
 */
class MusicEvent extends Event
{
    /**
     * @var Person[]
     */
    protected array $composers = [];

    public function addComposer(Person $person): void
    {
        $this->composers[] = $person;
    }

    /**
     * @return string[]|array[]
     */
    public function schema(): array
    {
        return array_filter(array_merge(parent::schema(), [
            '@type'     => 'MusicEvent',
            'composers' => $this->getSchema('composers'),
        ]));
    }
}
