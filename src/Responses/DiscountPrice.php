<?php

namespace Edofre\NsApi\Responses;

use SimpleXMLElement;

/**
 * Class DiscountPrice
 * @package Edofre\NsApi\Responses
 */
class DiscountPrice
{
    /** @var  string */
    public $name;
    /** @var  float */
    public $price;

    /**
     * TravelType constructor.
     * @param $name
     * @param $price
     */
    function __construct($name, $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    /**
     * @param SimpleXMLElement $xml
     * @return DiscountPrice
     */
    public static function createFromXml(SimpleXMLElement $xml)
    {
        return new self(
            (string)$xml->Naam,
            (string)$xml->Prijs
        );
    }
}