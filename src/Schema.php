<?php
namespace Clubdeuce\Schema;

class Schema
{
    public function makePerson(array $data  = []): Person
    {
        return new Person($data);
    }

    public function makeMusicComposition(array $data = []): MusicComposition
    {
        return new MusicComposition($data);
    }

    public function makeMusicEvent(array $data = []): MusicEvent
    {
        return new MusicEvent($data);
    }

    public function makeOffer(array $data = []): Offer
    {
        return new Offer($data);
    }
}
