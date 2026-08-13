<?php
namespace Clubdeuce\Schema;

class SchemaFactory
{
    public function makeCreativeWork(array $data = []): CreativeWork
    {
        return new CreativeWork($data);
    }

    public function makeEvent(array $data = []): Event
    {
        return new Event($data);
    }

    public function makeEventSeries(array $data = []): EventSeries
    {
        return new EventSeries($data);
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

    public function makeOrganization(array $data = []): Organization
    {
        return new Organization($data);
    }

    public function makePerson(array $data  = []): Person
    {
        return new Person($data);
    }

    public function makePlace(array $data = []): Place
    {
        return new Place($data);
    }

    public function makePostalAddress(array $data = []): PostalAddress
    {
        return new PostalAddress($data);
    }

    public function makeTheaterEvent(array $data = []): TheaterEvent
    {
        return new TheaterEvent($data);
    }
}
