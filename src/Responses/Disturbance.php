<?php

namespace Edofre\NsApi\Responses;

use SimpleXMLElement;

/**
 * Class Disturbance
 * @package Edofre\NsApi\Responses
 */
class Disturbance
{
    /** @var  string */
    public $id;
    /** @var  string */
    public $route;
    /** @var  string */
    public $period;
    /** @var  string */
    public $reason;
    /** @var  string */
    public $advice;
    /** @var  string */
    public $message;
    /** @var  boolean */
    public $planned;

    /**
     * Disturbance constructor.
     * @param $id
     * @param $route
     * @param $period
     * @param $message
     * @param $planned
     */
    function __construct($id, $route, $period, $reason, $advice, $message, $planned)
    {
        $this->id = $id;
        $this->route = $route;
        $this->period = $period;
        $this->reason = $reason;
        $this->advice = $advice;
        $this->message = $message;
        $this->planned = $planned;
    }

    /**
     * @param SimpleXMLElement $xml
     * @param boolean          $planned
     * @return Disturbance
     */
    public static function createFromXml(SimpleXMLElement $xml, $planned)
    {
        return new self(
            (string)$xml->id,
            (string)$xml->Traject,
            (string)$xml->Periode,
            (string)$xml->Reden,
            (string)$xml->Advies,
            (string)$xml->Bericht,
            $planned
        );
    }
}