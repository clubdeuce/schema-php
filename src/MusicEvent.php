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

    /**
     * @var CreativeWork[]
     */
    protected array $worksPerformed = [];

    /**
     * @return string[]|array[]
     */
    public function schema(): array
    {
        return array_filter(array_merge(parent::schema(), [
            '@type'     => 'MusicEvent',
            'composers' => $this->getSchema($this->composers),
        ]));
    }

    /** @return CreativeWork[] */
    public function worksPerformed(): array {
        return $this->worksPerformed;
    }

    /**
     * Set the works performed.
     *
     * @param CreativeWork[] $worksPerformed
     * @return self
     */
    public function setWorksPerformed( array $worksPerformed ): static {
        $this->worksPerformed = $worksPerformed;
        return $this;
    }
}
