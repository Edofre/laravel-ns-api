<?php

namespace Edofre\NsApi\Responses;

use SimpleXMLElement;

/**
 * Class TravelType
 * @package Edofre\NsApi\Responses
 */
class TravelType
{
    /** @var  string */
    public $name;
    public $travel_classes = [];

    /**
     * TravelType constructor.
     * @param $name
     * @param $travel_classes
     */
    function __construct($name, $travel_classes)
    {
        $this->name = $name;
        $this->travel_classes = $travel_classes;
    }

    /**
     * @param SimpleXMLElement $xml
     * @return TravelType
     */
    public static function createFromXml(SimpleXMLElement $xml)
    {
        return new self(
            (string)$xml->Naam,
            []
        );
    }
}