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

    public function setComposer(Person $composer): static
    {
        $this->composer = $composer;
        return $this;
    }

    public function setForm(string $form): static
    {
        $this->form = $form;
        return $this;
    }

    public function setLyricist(Person $lyricist): static
    {
        $this->lyricist = $lyricist;
        return $this;
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
