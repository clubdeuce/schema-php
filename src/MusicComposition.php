<?php

namespace Clubdeuce\Schema;

/**
 * @link https://schema.org/MusicComposition
 */
class MusicComposition extends Thing
{
    protected Person $composer;

    /**
     * The musical form, e.g., sonata, symphony, overture, etc.
     */
    protected string $form = '';

    protected Person $lyricist;

    public function setComposer(Person $composer): void
    {
        $this->composer = $composer;
    }

    public function setForm(string $form): void
    {
        $this->form = $form;
    }

    public function setLyricist(Person $lyricist): void
    {
        $this->lyricist = $lyricist;
    }

    /**
     * @return string[]
     */
    function schema(): array
    {
        return array_filter(array_merge(parent::schema(), [
            '@type'                => 'MusicComposition',
            'composer'             => isset($this->composer) ? $this->composer->schema() : null,
            'lyricist'             => isset($this->lyricist) ? $this->lyricist->schema() : null,
            'musicCompositionForm' => $this->form,
        ]));
    }
}
