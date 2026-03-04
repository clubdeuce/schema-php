<?php

namespace Clubdeuce\Schema;

use DateInterval;
use DateTime;

class MusicEvent extends Thing
{
    /**
     * @var Person[]
     */
    protected array $composers = array();

    /**
     * @var Person[]
     */
    protected array $directors = array();

    protected ?DateTime $doorTime = null;

    protected ?DateInterval $duration = null;

    protected ?DateTime $endDate = null;

    protected string $eventStatus = 'EventScheduled';

    /**
     * @var Offer[]
     */
    protected array $offers = array();

    protected ?Place $place = null;

    /**
     * @var Person[]|Organization[]
     */
    protected array $performers = array();

    /**
     * @var Organization[]
     */
    protected array $sponsors = array();

    protected ?DateTime $startDate = null;

    public function addComposer($person): int
    {
        $this->composers[] = $person;
        return count($this->composers);
    }

    public function addDirector($person): int
    {
        $this->directors[] = $person;
        return count($this->directors);
    }

    public function addOffer($offer): int
    {
        $this->offers[] = $offer;
        return count($this->offers);
    }

    public function addPerformer($performer): int
    {
        $this->performers[] = $performer;
        return count($this->performers);
    }

    public function addSponsor($sponsor): int
    {
        $this->sponsors[] = $sponsor;
        return count($this->sponsors);
    }

    public function setDoorTime(DateTime $doorTime): void
    {
        $this->doorTime = $doorTime;
    }

    /**
     * @return string[]|array[]
     */
    public function schema(): array
    {

        $schema = array(
            '@type'       => 'MusicEvent',
            'composers'   => $this->getSchema('composers'),
            'directors'   => $this->getSchema('directors'),
            'doorTime'    => $this->doorTime?->format(DATE_ATOM),
            'endDate'     => $this->endDate?->format(DATE_ATOM),
            'duration'    => $this->duration?->format('P%yY%mM%dDT%hH%iM%sS'),
            'eventStatus' => $this->eventStatus,
            'location'    => $this->place?->schema(),
            'offers'      => $this->getSchema('offers'),
            'performers'  => $this->getSchema('performers'),
            'sponsors'    => $this->getSchema('sponsors'),
            'startDate'   => $this->startDate?->format(DATE_ATOM),
        );

        $schema = array_merge(parent::schema(), $schema);

        return array_filter($schema);

    }

    /**
     * @param string $propertyName
     *
     * @return Offer[]|Organization[]|Person[]
     */
    protected function getSchema(string $propertyName): array
    {

        $schema = [];

        if (property_exists($this, $propertyName)) {
            foreach ($this->{$propertyName} as $item) {
                /**
                 * @var Thing $item
                 */
                $schema[] = $item->schema();
            }
        }

        return $schema;

    }

    /**
     * @return DateTime|null
     */
    protected function doorTime(): ?DateTime
    {

        $door_time = null;

        if ($this->doorTime) {
            $door_time = $this->doorTime;
        }

        return $door_time;

    }

    /**
     * @return DateTime|null
     */
    protected function endDate(): ?DateTime
    {

        if (!isset($this->endDate)) {
            if (isset($this->duration) && !is_null($this->startDate)) {
                $this->endDate = (clone $this->startDate)->add($this->duration);
            }
        }

        return $this->endDate;

    }
}