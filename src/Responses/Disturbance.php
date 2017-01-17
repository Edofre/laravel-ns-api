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
    public $message;
    /** @var  boolean */
    public $planned;

    /**
     * Station constructor.
     * @param $id
     * @param $route
     * @param $period
     * @param $message
     * @param $planned
     */
    function __construct($id, $route, $period, $message, $planned)
    {
        $this->id = $id;
        $this->route = $route;
        $this->period = $period;
        $this->message = $message;
        $this->planned = $planned;
    }

    /**
     * @param SimpleXMLElement $xml
     * @return Disturbance
     */
    public static function createFromXml(SimpleXMLElement $xml)
    {
        return new self(
            (string)$xml->id,
            (string)$xml->Traject,
            (array)$xml->Periode,
            (array)$xml->Bericht,
            false
        );
    }
}