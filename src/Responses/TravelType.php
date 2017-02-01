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
    /** @var  array */
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
        $travel_classes = [];
        if (!empty($xml->ReisKlasse)) {
            foreach ($xml->ReisKlasse as $travel_class) {
                $travel_classes[] = TravelClass::createFromXml($travel_class);
            }
        }

        return new self(
            (string)$xml['name'],
            $travel_classes
        );
    }
}