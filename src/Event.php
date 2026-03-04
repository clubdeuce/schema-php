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

    public function addDirector( Person $person ): void {

        $this->directors[] = $person;

    }

    public function addOffer( Offer $offer ): void {

        $this->offers[] = $offer;

    }

    public function addOrganizer( Organization|Person $organizer ): void {

        $this->organizers[] = $organizer;

    }

    public function addPerformer( Organization|Person $performer ): void {

        $this->performers[] = $performer;

    }

    public function addSponsor( Organization|Person $sponsor ): void {

        $this->sponsors[] = $sponsor;

    }

    public function setDuration( DateInterval $duration ): void {

        $this->duration = $duration;

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
    public function setOrganizers( array $organizers ): self {
        $this->organizers = $organizers;
        return $this;
    }

    /**
     * Set directors.
     *
     * @param Person[] $directors
     * @return self
     */
    public function setDirectors( array $directors ): self {
        $this->directors = $directors;
        return $this;
    }

    /**
     * Set door time.
     *
     * @param DateTime|null $doorTime
     * @return self
     */
    public function setDoorTime( ?DateTime $doorTime ): self {
        $this->doorTime = $doorTime;
        return $this;
    }

    /**
     * Set end date.
     *
     * @param DateTime|null $endDate
     * @return self
     */
    public function setEndDate( ?DateTime $endDate ): self {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * Set event status.
     *
     * @param string $eventStatus
     * @return self
     */
    public function setEventStatus( string $eventStatus ): self {
        $this->eventStatus = $eventStatus;
        return $this;
    }

    /**
     * Set offers.
     *
     * @param Offer[] $offers
     * @return self
     */
    public function setOffers( array $offers ): self {
        $this->offers = $offers;
        return $this;
    }

    /**
     * Set place.
     *
     * @param Place|null $place
     * @return self
     */
    public function setPlace( ?Place $place ): self {
        $this->place = $place;
        return $this;
    }

    /**
     * Set performers.
     *
     * @param array $performers
     * @return self
     */
    public function setPerformers( array $performers ): self {
        $this->performers = $performers;
        return $this;
    }

    /**
     * Set sponsors.
     *
     * @param array $sponsors
     * @return self
     */
    public function setSponsors( array $sponsors ): self {
        $this->sponsors = $sponsors;
        return $this;
    }

    /**
     * Set start date.
     *
     * @param DateTime|null $startDate
     * @return self
     */
    public function setStartDate( ?DateTime $startDate ): self {
        $this->startDate = $startDate;
        return $this;
    }
}
