<?php

namespace Clubdeuce\Schema;

/**
 * Class Music_Composition
 * @package DSO\Modules\Schema
 *
 * @method void setComposer(Person $composer)
 * @method void setForm(string $form)
 * @method void setLyricist(Person $composer)
 *
 * @link https://schema.org/MusicComposition
 */
class MusicComposition extends Thing
{
    protected Person $_composer;

    /**
     * The musical form, e.g., sonata, symphony, overture, etc.
     */
    protected string $_form = '';

    protected Person $_lyricist;

    /**
     * @return string[]
     */
    function schema(): array
    {
        return array_merge(parent::schema(), array(
            '@type'                => 'MusicComposition',
            'composer'             => isset($this->_composer) ? $this->_composer->schema() : null,
            'lyricist'             => isset($this->_lyricist) ? $this->_lyricist->schema() : null,
            'musicCompositionForm' => $this->_form,
        ));
    }
}
