<?php

namespace Clubdeuce\Schema;

use DateInterval;
use DateTime;

/**
 * Class Event
 *
 * @link https://schema.org/Event
 */
class Event extends Thing {

    /**
     * @var Person[]
     */
    protected array $directors = [];

    protected ?DateTime $doorTime = null;

    protected ?DateInterval $duration = null;

    protected ?DateTime $endDate = null;

    protected string $eventStatus = 'EventScheduled';

    /**
     * @var Offer[]
     */
    protected array $offers = [];

    /**
     * @var Person[]|Organization[]
     */
    protected array $organizers = [];

    protected ?Place $place = null;

    /**
     * @var Person[]|Organization[]
     */
    protected array $performers = [];

    /**
     * @var Person[]|Organization[]
     */
    protected array $sponsors = [];

    protected ?DateTime $startDate = null;

    public function addDirector( Person $person ): static {

        $this->directors[] = $person;
        return $this;

    }

    public function addOffer( Offer $offer ): static {

        $this->offers[] = $offer;
        return $this;

    }

    public function addOrganizer( Organization|Person $organizer ): static {

        $this->organizers[] = $organizer;
        return $this;

    }

    public function addPerformer( Organization|Person $performer ): static {

        $this->performers[] = $performer;
        return $this;

    }

    public function addSponsor( Organization|Person $sponsor ): static {

        $this->sponsors[] = $sponsor;
        return $this;

    }

    public function setDuration( DateInterval $duration ): static {

        $this->duration = $duration;
        return $this;

    }

    /**
     * @return string[]
     */
    public function schema(): array {

        $schema = [
            '@type'       => 'Event',
            'directors'   => $this->getSchema( $this->directors ),
            'doorTime'    => $this->doorTime()?->format( DATE_ATOM ),
            'endDate'     => $this->resolveEndDate()?->format( DATE_ATOM ),
            'duration'    => isset( $this->duration ) ? $this->duration->format( 'P%yY%mM%dDT%hH%iM%sS' ) : null,
            'eventStatus' => $this->eventStatus,
            'location'    => $this->place?->schema(),
            'offers'      => $this->getSchema( $this->offers ),
            'organizers'  => $this->getSchema( $this->organizers ),
            'performers'  => $this->getSchema( $this->performers ),
            'sponsors'    => $this->getSchema( $this->sponsors ),
            'startDate'   => isset( $this->startDate ) ? $this->startDate()->format( DATE_ATOM ) : null,
        ];

        $schema = array_merge( parent::schema(), $schema );

        return array_filter( $schema );

    }


    private function resolveEndDate(): ?DateTime
    {
        if ($this->endDate !== null) {
            return $this->endDate;
        }

        if ($this->duration !== null && $this->startDate !== null) {
            return (clone $this->startDate)->add($this->duration);
        }

        return null;
    }

    // Getters
    /** @return Person[] */
    public function directors(): array {
        return $this->directors;
    }

    public function doorTime(): ?DateTime {
        return $this->doorTime;
    }

    public function duration(): ?DateInterval {
        return $this->duration;
    }

    public function endDate(): ?DateTime {
        return $this->resolveEndDate();
    }

    public function eventStatus(): string {
        return $this->eventStatus;
    }

    /** @return Offer[] */
    public function offers(): array {
        return $this->offers;
    }

    public function place(): ?Place {
        return $this->place;
    }

    /** @return Person[]|Organization[] */
    public function performers(): array {
        return $this->performers;
    }

    /** @return Person[]|Organization[] */
    public function sponsors(): array {
        return $this->sponsors;
    }

    /** @return Person[]|Organization[] */
    public function organizers(): array {
        return $this->organizers;
    }

    public function startDate(): ?DateTime {
        return $this->startDate ?? null;
    }

    // Deprecated get* aliases — use the no-prefix getters above instead
    /** @deprecated Use directors() */
    public function getDirectors(): array { return $this->directors(); }
    /** @deprecated Use doorTime() */
    public function getDoorTime(): ?DateTime { return $this->doorTime(); }
    /** @deprecated Use duration() */
    public function getDuration(): ?DateInterval { return $this->duration(); }
    /** @deprecated Use endDate() */
    public function getEndDate(): ?DateTime { return $this->endDate(); }
    /** @deprecated Use eventStatus() */
    public function getEventStatus(): string { return $this->eventStatus(); }
    /** @deprecated Use offers() */
    public function getOffers(): array { return $this->offers(); }
    /** @deprecated Use place() */
    public function getPlace(): ?Place { return $this->place(); }
    /** @deprecated Use performers() */
    public function getPerformers(): array { return $this->performers(); }
    /** @deprecated Use sponsors() */
    public function getSponsors(): array { return $this->sponsors(); }
    /** @deprecated Use organizers() */
    public function getOrganizers(): array { return $this->organizers(); }

    // Setters
    /**
     * @param Person[]|Organization[] $organizers
     * @return self
     */
    public function setOrganizers( array $organizers ): static {
        $this->organizers = $organizers;
        return $this;
    }

    /**
     * Set directors.
     *
     * @param Person[] $directors
     * @return self
     */
    public function setDirectors( array $directors ): static {
        $this->directors = $directors;
        return $this;
    }

    /**
     * Set door time.
     *
     * @param DateTime|null $doorTime
     * @return self
     */
    public function setDoorTime( ?DateTime $doorTime ): static {
        $this->doorTime = $doorTime;
        return $this;
    }

    /**
     * Set end date.
     *
     * @param DateTime|null $endDate
     * @return self
     */
    public function setEndDate( ?DateTime $endDate ): static {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * Set event status.
     *
     * @param string $eventStatus
     * @return self
     */
    public function setEventStatus( string $eventStatus ): static {
        $this->eventStatus = $eventStatus;
        return $this;
    }

    /**
     * Set offers.
     *
     * @param Offer[] $offers
     * @return self
     */
    public function setOffers( array $offers ): static {
        $this->offers = $offers;
        return $this;
    }

    /**
     * Set place.
     *
     * @param Place|null $place
     * @return self
     */
    public function setPlace( ?Place $place ): static {
        $this->place = $place;
        return $this;
    }

    /**
     * Set performers.
     *
     * @param array $performers
     * @return self
     */
    public function setPerformers( array $performers ): static {
        $this->performers = $performers;
        return $this;
    }

    /**
     * Set sponsors.
     *
     * @param array $sponsors
     * @return self
     */
    public function setSponsors( array $sponsors ): static {
        $this->sponsors = $sponsors;
        return $this;
    }

    /**
     * Set start date.
     *
     * @param DateTime|null $startDate
     * @return self
     */
    public function setStartDate( ?DateTime $startDate ): static {
        $this->startDate = $startDate;
        return $this;
    }
}
