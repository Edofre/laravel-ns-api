<?php

namespace Edofre\NsApi\Responses;

use SimpleXMLElement;

/**
 * Class PricePart
 * @package Edofre\NsApi\Responses
 */
class PricePart
{
    /** @var  string */
    public $carrier;
    /** @var  string */
    public $price;
    /** @var  string */
    public $to;
    /** @var  string */
    public $from;

    /**
     * Station constructor.
     * @param $carrier
     * @param $price
     * @param $to
     * @param $from
     */
    function __construct($carrier, $price, $to, $from)
    {
        $this->carrier = $carrier;
        $this->price = $price;
        $this->to = $to;
        $this->from = $from;
    }

    /**
     * @param SimpleXMLElement $xml
     * @return PricePart
     */
    public static function createFromXml(SimpleXMLElement $xml)
    {
        return new self(
            (string)$xml['vervoerder'],
            (string)$xml['prijs'],
            (string)$xml['naar'],
            (string)$xml['van']
        );
    }
}