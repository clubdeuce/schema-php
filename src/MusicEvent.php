<?php

namespace Clubdeuce\Schema;

use DateInterval;
use DateTime;

class MusicEvent extends Base
{
    /**
     * @var Person[]
     */
    protected array $_composers = array();

    /**
     * @var Person[]
     */
    protected array $_directors = array();

    protected ?DateTime $_doorTime = null;

    protected ?DateInterval $_duration = null;

    protected ?DateTime $_endDate = null;

    protected string $_eventStatus = 'EventScheduled';

    /**
     * @var Offer[]
     */
    protected array $_offers = array();

    protected ?Place $_place = null;

    /**
     * @var Person[]|Organization[]
     */
    protected array $_performers = array();

    /**
     * @var Organization[]
     */
    protected array $_sponsors = array();

    protected ?DateTime $_startDate = null;

    public function addComposer($person): int
    {
        $this->_composers[] = $person;
        return count($this->_composers);
    }

    public function addDirector($person): int
    {
        $this->_directors[] = $person;
        return count($this->_directors);
    }

    public function addOffer($offer): int
    {
        $this->_offers[] = $offer;
        return count($this->_offers);
    }

    public function addPerformer($performer): int
    {
        $this->_performers[] = $performer;
        return count($this->_performers);
    }

    public function addSponsor($sponsor): int
    {
        $this->_sponsors[] = $sponsor;
        return count($this->_sponsors);
    }

    public function setDoorTime(DateTime $doorTime): void
    {
        $this->door_time = $doorTime;
    }

    /**
     * @return string[]|array[]
     */
    public function schema(): array
    {

        $schema = array(
            '@type'       => 'MusicEvent',
            'composers'   => $this->_getSchema('_composers'),
            'directors'   => $this->_getSchema('_directors'),
            'doorTime'    => $this->_doorTime?->format(DATE_ATOM),
            'endDate'     => $this->_endDate?->format(DATE_ATOM),
            'duration'    => $this->_duration?->format('P%yY%mM%dDT%hH%iM%sS'),
            'eventStatus' => $this->_eventStatus,
            'location'    => $this->_place?->schema(),
            'offers'      => $this->_getSchema('_offers'),
            'performers'  => $this->_getSchema('_performers'),
            'sponsors'    => $this->_getSchema('_sponsors'),
            'startDate'   => $this->_startDate?->format(DATE_ATOM),
        );

        $schema = array_merge(parent::schema(), $schema);

        return array_filter($schema);

    }

    /**
     * @param string $propertyName
     *
     * @return Offer[]|Organization[]|Person[]
     */
    protected function _getSchema(string $propertyName): array
    {

        $schema = [];

        if (property_exists($this, $propertyName)) {
            foreach ($this->{$propertyName} as $item) {
                /**
                 * @var Base $item
                 */
                $schema[] = $item->schema();
            }
        }

        return $schema;

    }

    /**
     * @return DateTime|null
     */
    protected function _doorTime(): ?DateTime
    {

        $door_time = null;

        if ($this->_doorTime) {
            $door_time = $this->_doorTime;
        }

        return $door_time;

    }

    /**
     * @return DateTime|null
     */
    protected function _endDate(): ?DateTime
    {

        if (!isset($this->_endDate)) {
            if (isset($this->_duration)) {
                $this->_endDate = (clone $this->_startDate)->add($this->_duration);
            }
        }

        return $this->_endDate;

    }
}