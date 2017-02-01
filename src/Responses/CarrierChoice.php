<?php

namespace Edofre\NsApi\Responses;

use SimpleXMLElement;

/**
 * Class CarrierChoice
 * @package Edofre\NsApi\Responses
 */
class CarrierChoice
{
    /** @var  string */
    public $name;
    public $rate_units;
    public $travel_types = [];

    /**
     * CarrierChoice constructor.
     * @param $name
     * @param $rate_units
     * @param $travel_types
     */
    function __construct($name, $rate_units, $travel_types)
    {
        $this->name = $name;
        $this->rate_units = $rate_units;
        $this->travel_types = $travel_types;
    }

    /**
     * @param SimpleXMLElement $xml
     * @return CarrierChoice
     */
    public static function createFromXml(SimpleXMLElement $xml)
    {
        $travel_types = [];
        if (!empty($xml->ReisType)) {
            foreach ($xml->ReisType as $travel_type) {
                $travel_types[] = TravelType::createFromXml($travel_type);
            }
        }

        return new self(
            (string)$xml['Naam'],
            (string)$xml->Tariefeenheden,
            $travel_types
        );
    }
}