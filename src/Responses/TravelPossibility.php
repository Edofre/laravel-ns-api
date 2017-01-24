<?php

namespace Edofre\NsApi\Responses;

use SimpleXMLElement;

/**
 * Class TravelPossibility
 * @package Edofre\NsApi\Responses
 */
class TravelPossibility
{
    /** @var  string */
    public $number_of_switches;
    public $planned_travel_time;
    public $actual_travel_time;
    public $optimal;
    public $planned_departure_time;
    public $actual_departure_time;
    public $planned_arrival_time;
    public $actual_arrival_time;
    public $status;
    public $travel_sections = [];

    /**
     * Advice constructor.
     * @param $number_of_switches
     * @param $planned_travel_time
     * @param $actual_travel_time
     * @param $optimal
     * @param $planned_departure_time
     * @param $actual_departure_time
     * @param $planned_arrival_time
     * @param $actual_arrival_time
     * @param $status
     * @param $travel_sections
     */
    function __construct($number_of_switches, $planned_travel_time, $actual_travel_time, $optimal, $planned_departure_time, $actual_departure_time, $planned_arrival_time, $actual_arrival_time, $status, $travel_sections)
    {
        $this->number_of_switches = $number_of_switches;
        $this->planned_travel_time = $planned_travel_time;
        $this->actual_travel_time = $actual_travel_time;
        $this->optimal = $optimal;
        $this->planned_departure_time = $planned_departure_time;
        $this->actual_departure_time = $actual_departure_time;
        $this->planned_arrival_time = $planned_arrival_time;
        $this->actual_arrival_time = $actual_arrival_time;
        $this->status = $status;
        $this->travel_sections = $travel_sections;
    }

    /**
     * @param SimpleXMLElement $xml
     * @return Advice
     */
    public static function createFromXml(SimpleXMLElement $xml)
    {
        return new self(
            (string)$xml->AantalOverstappen,
            (string)$xml->GeplandeReisTijd,
            (string)$xml->ActueleReisTijd,
            (string)$xml->Optimaal,
            (string)$xml->GeplandeVertrekTijd,
            (string)$xml->ActueleVertrekTijd,
            (string)$xml->GeplandeAankomstTijd,
            (string)$xml->ActueleAankomstTijd,
            (string)$xml->Status
        );
    }
}