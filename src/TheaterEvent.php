<?php

namespace Clubdeuce\Schema;

/**
 * @link https://schema.org/TheaterEvent
 */
class TheaterEvent extends Event {

    /**
     * @var CreativeWork[]
     */
    protected array $worksPerformed = [];

    public function addWorkPerformed( CreativeWork $work ): static {

        $this->worksPerformed[] = $work;
        return $this;

    }

    /**
     * @return string[]
     */
    public function schema(): array {

        $schema = [
            '@type'         => 'TheaterEvent',
            'workPerformed' => $this->getSchema( $this->worksPerformed ),
        ];

        $schema = array_merge( parent::schema(), $schema );

        return array_filter( $schema );

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
