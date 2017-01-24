<?php

namespace Edofre\NsApi\Responses;

use SimpleXMLElement;

/**
 * Class TravelSection
 * @package Edofre\NsApi\Responses
 */
class TravelSection
{
    /** @var  string */
    public $travel_type;
    /** @var  string */
    public $carrier;
    /** @var  string */
    public $carrier_type;
    /** @var  string */
    public $ride_number;
    /** @var  string */
    public $status;
    /** @var  array */
    public $travel_stops = [];

    /**
     * TravelSection constructor.
     * @param $travel_type
     * @param $carrier
     * @param $carrier_type
     * @param $ride_number
     * @param $status
     */
    function __construct($travel_type, $carrier, $carrier_type, $ride_number, $status)
    {
        $this->travel_type = $travel_type;
        $this->carrier = $carrier;
        $this->carrier_type = $carrier_type;
        $this->ride_number = $ride_number;
        $this->status = $status;
    }

    /**
     * @param SimpleXMLElement $xml
     * @return TravelSection
     */
    public static function createFromXml(SimpleXMLElement $xml)
    {
        return new self(
            (string)$xml->reisSoort,
            (string)$xml->Vervoerder,
            (string)$xml->VervoerType,
            (string)$xml->RitNummer,
            (string)$xml->RitNummer,
            (string)$xml->Status
        );
    }
}