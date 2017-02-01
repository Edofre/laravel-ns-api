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
    /** @var  string */
    public $total;
    /** @var  array */
    public $discount_prices = [];
    /** @var null|PricePart */
    public $price_part;

    /**
     * TravelClass constructor.
     * @param $class
     * @param $total
     * @param $discount_prices
     * @param $price_part
     */
    function __construct($class, $total, $discount_prices, $price_part)
    {
        $this->class = $class;
        $this->total = $total;
        $this->discount_prices = $discount_prices;
        $this->price_part = $price_part;
    }

    /**
     * @param SimpleXMLElement $xml
     * @return TravelClass
     */
    public static function createFromXml(SimpleXMLElement $xml)
    {
        $discount_prices = [];
        if (!empty($xml->Korting)) {
            foreach ($xml->Korting->Kortingsprijs as $discount_price) {
                $discount_prices[] = DiscountPrice::createFromXml($discount_price);
            }
        }

        $price_part = null;

        // We need to store this in a variable because otherwise it's marked as empty
        $prijsdeel = ($xml->Prijsdeel);
        if (!empty($prijsdeel)) {
            $price_part = PricePart::createFromXml($prijsdeel);
        }

        return new self(
            (string)$xml['klasse'],
            (string)$xml->total,
            $discount_prices,
            $price_part
        );
    }
}