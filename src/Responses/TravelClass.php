<?php

namespace Edofre\NsApi\Responses;

use SimpleXMLElement;

/**
 * Class TravelClass
 * @package Edofre\NsApi\Responses
 */
class TravelClass
{
    /** @var  string */
    public $class;
    /** @var  array */
    public $price_parts = [];
    /** @var  array */
    public $discount_prices = [];

    /**
     * TravelClass constructor.
     * @param $class
     * @param $price_parts
     * @param $discount_prices
     */
    function __construct($class, $price_parts, $discount_prices)
    {
        $this->class = $class;
        $this->price_parts = $price_parts;
        $this->discount_prices = $discount_prices;
    }

    /**
     * @param SimpleXMLElement $xml
     * @return TravelClass
     */
    public static function createFromXml(SimpleXMLElement $xml)
    {
        return new self(
            (string)$xml->Klasse,
            (string)$xml->Prijsdeel,
            (string)$xml->Korting
        );
    }
}