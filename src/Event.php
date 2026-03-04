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
            'directors'   => $this->getSchema( 'directors' ),
            'doorTime'    => $this->doorTime()?->format( DATE_ATOM ),
            'endDate'     => $this->endDate()?->format( DATE_ATOM ),
            'duration'    => isset( $this->duration ) ? $this->duration->format( 'P%yY%mM%dDT%hH%iM%sS' ) : null,
            'eventStatus' => $this->eventStatus,
            'location'    => $this->place?->schema(),
            'offers'      => $this->getSchema( 'offers' ),
            'organizers'  => $this->getSchema( 'organizers' ),
            'performers'  => $this->getSchema( 'performers' ),
            'sponsors'    => $this->getSchema( 'sponsors' ),
            'startDate'   => isset( $this->startDate ) ? $this->startDate()->format( DATE_ATOM ) : null,
        ];

        $schema = array_merge( parent::schema(), $schema );

        return array_filter( $schema );

    }

    protected function doorTime(): ?DateTime {

        $doorTime = null;

        if ( $this->doorTime ) {
            $doorTime = $this->doorTime;
        }

        return $doorTime;

    }

    protected function endDate(): ?DateTime {

        if ( ! isset( $this->endDate ) ) {
            if ( isset( $this->duration ) ) {
                $this->endDate = ( clone $this->startDate() )->add( $this->duration );
            }
        }

        return $this->endDate;

    }

    // Getters
    /**
     * @return Person[]
     */
    public function getDirectors(): array {
        return $this->directors;
    }

    /**
     * Get door time.
     *
     * @return DateTime|null
     */
    public function getDoorTime(): ?DateTime {
        return $this->doorTime;
    }

    /**
     * Get duration.
     *
     * @return DateInterval|null
     */
    public function getDuration(): ?DateInterval {
        return $this->duration;
    }

    /**
     * Get end date.
     *
     * @return DateTime|null
     */
    public function getEndDate(): ?DateTime {
        return $this->endDate ?? null;
    }

    /**
     * Get event status.
     *
     * @return string
     */
    public function getEventStatus(): string {
        return $this->eventStatus;
    }

    /**
     * Get offers.
     *
     * @return Offer[]
     */
    public function getOffers(): array {
        return $this->offers;
    }

    /**
     * Get place.
     *
     * @return Place|null
     */
    public function getPlace(): ?Place {
        return $this->place;
    }

    /**
     * Get performers.
     *
     * @return array
     */
    public function getPerformers(): array {
        return $this->performers;
    }

    /**
     * @return array
     */
    public function getSponsors(): array {
        return $this->sponsors;
    }

    /**
     * @return Person[]|Organization[]
     */
    public function getOrganizers(): array {
        return $this->organizers;
    }

    /**
     * Get start date.
     *
     * @return DateTime|null
     */
    public function startDate(): ?DateTime {
        return $this->startDate ?? null;
    }

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
