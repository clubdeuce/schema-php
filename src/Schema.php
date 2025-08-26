<?php
namespace Clubdeuce\Schema;

class Schema
{
    public function make_person( array $data  = [] ): Person
    {
        return new Person($data);
    }

    public function makeMusicComposition(array $data = []): MusicComposition
    {
        return new MusicComposition($data);
    }
}
