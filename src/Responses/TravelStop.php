<?php

namespace Edofre\NsApi\Responses;

use SimpleXMLElement;

/**
 * Class TravelStop
 * @package Edofre\NsApi\Responses
 */
class TravelStop
{
    /** @var  string */
    public $name;
    /** @var  string */
    public $time;
    /** @var  string */
    public $track;
    /** @var  boolean */
    public $track_changed = false;

    /**
     * TravelStop constructor.
     * @param      $name
     * @param      $time
     * @param      $track
     * @param bool $track_changed
     */
    function __construct($name, $time, $track, $track_changed = false)
    {
        $this->name = $name;
        $this->time = $time;
        $this->track = $name;
        $this->track_changed = $track_changed;
    }

    /**
     * @param SimpleXMLElement $xml
     * @return TravelStop
     */
    public static function createFromXml(SimpleXMLElement $xml)
    {
        return new self(
            (string)$xml->Naam,
            (string)$xml->Tijd,
            (string)$xml->Spoor
        );
    }
}