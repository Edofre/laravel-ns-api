<?php

namespace Edofre\NsApi\Responses;

use SimpleXMLElement;

/**
 * Class Station
 * @package Edofre\NsApi\Responses
 */
class Station
{
    /** @var string */
    public $code;
    /** @var string */
    public $type;
    /** @var array short/middle/long */
    public $names;
    /** @var  string */
    public $country;
    /** @var  string */
    public $uic_code;
    /** @var */
    public $lat;
    /** @var */
    public $lon;
    /** @var */
    public $aliases;

    /**
     * Station constructor.
     * @param $code
     * @param $type
     * @param $names
     * @param $country
     * @param $uic_code
     * @param $lat
     * @param $lon
     * @param $aliases
     */
    function __construct($code, $type, $names, $country, $uic_code, $lat, $lon, $aliases)
    {
        $this->code = $code;
        $this->type = $type;
        $this->names = $names;
        $this->country = $country;
        $this->uic_code = $uic_code;
        $this->lat = $lat;
        $this->lon = $lon;
        $this->aliases = $aliases;
    }

    /**
     * @param SimpleXMLElement $xml
     * @return Station
     */
    public static function createFromXml(SimpleXMLElement $xml)
    {
        return new self(
            (string)$xml->Code,
            (string)$xml->Type,
            (array)$xml->Namen,
            (string)$xml->Land,
            (string)$xml->UICCode,
            (string)$xml->Lat,
            (string)$xml->Lon,
            (array)$xml->Synoniemen->Synoniem
        );
    }
}