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
     * @var Person[]|Organization[]
     */
    protected array $organizers = [];

    /**
     * @var Person[]
     */
    protected array $directors = [];

    protected ?DateTime $doorTime;

    protected ?DateInterval $duration;

    protected DateTime $endDate;

    protected string $eventStatus = 'EventScheduled';

    /**
     * @var Offer[]
     */
    protected array $offers = [];

    protected ?Place $place = null;

    /**
     * @var Person[]|Organization[]
     */
    protected array $performers = [];

    /**
     * @var Person[]|Organization[]
     */
    protected array $sponsors = [];

    /**
     * @var Person[]|Organization[]
     */
    protected array $organizer = [];

    protected DateTime $startDate;

    function addComposer( Person $person ): void {

        $this->organizers[] = $person;

    }

    function addDirector( Person $person ): void {

        $this->directors[] = $person;

    }

    function addOffer( Offer $offer ): void {

        $this->offers[] = $offer;

    }

    function addPerformer( Organization|Person $performer ): void {

        $this->performers[] = $performer;

    }

    function addSponsor( Organization|Person $sponsor ): void {

        $this->sponsors[] = $sponsor;

    }

    function setDuration( DateInterval $duration ): void {

        $this->duration = $duration;

    }

    /**
     * @return Person[]|Organization[]
     */
    function organizer(): array {

        return $this->organizer;

    }

    /**
     * @return string[]
     */
    function schema(): array {

        $schema = [
            '@type'       => 'Event',
            'doorTime'    => isset( $this->doorTime ) ? $this->doorTime()->format( DATE_ATOM ) : null,
            'endDate'     => isset( $this->endDate ) ? $this->endDate()->format( DATE_ATOM ) : null,
            'duration'    => isset( $this->duration ) ? $this->duration->format( 'P%yY%mM%dDT%hH%iM%sS' ) : null,
            'eventStatus' => $this->eventStatus,
            'location'    => $this->place?->schema(),
            'offers'      => $this->getSchema( 'offers' ),
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
     * Get composers.
     *
     * @return Person[]
     */
    public function getOrganizers(): array {
        return $this->organizers;
    }

    /**
     * Get directors.
     *
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
     * Get sponsors.
     *
     * @return array
     */
    public function getSponsors(): array {
        return $this->sponsors;
    }

    /**
     * Get organizer.
     *
     * @return array
     */
    public function getOrganizer(): array {
        return $this->organizer;
    }

    /**
     * Get start date.
     *
     * @return DateTime|null
     */
    public function startDate(): ?DateTime {
        return $this->startDate ?? null;
    }

    // Setters`
    /**
     * Set composers.
     *
     * @param Person[] $composers
     * @return self
     */
    public function setOrganizers(array $composers ): self {
        $this->organizers = $composers;
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
     * Add an event organizer.
     *
     * @param array $organizer
     * @return self
     */
    public function addOrganizer( $organizer ): self {
        $this->organizer[] = $organizer;
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

    /**
     * @param string $propertyName
     *
     * @return array
     */
    protected function getSchema( string $propertyName ): array {

        $schema = [];

        if ( property_exists( $this, $propertyName ) ) {
            foreach ( $this->{$propertyName} as $item ) {
                /**
                 * @var Thing $item
                 */
                $schema[] = $item->schema();
            }
        }

        return $schema;

    }
}
