<?php

namespace Clubdeuce\Schema;

/**
 * @link https://schema.org/CreativeWork
 */
class CreativeWork extends Thing {

    /**
     * @var Person[]
     */
    protected array $authors = [];

    public function addAuthor( Person $author ): static {

        $this->authors[] = $author;
        return $this;

    }

    /**
     * @return string[]
     */
    public function schema(): array {

        $schema = [
            '@type' => 'CreativeWork',
            'author' => $this->getSchema( $this->authors ),
        ];

        $schema = array_merge( parent::schema(), $schema );

        return array_filter( $schema );

    }

    /**
     * @return Person[]
     */
    public function authors(): array {
        return $this->authors;
    }

    /**
     * Set authors.
     *
     * @param Person[] $authors
     * @return self
     */
    public function setAuthors( array $authors ): static {
        $this->authors = $authors;
        return $this;
    }
}
