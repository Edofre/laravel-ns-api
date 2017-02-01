<?php

namespace Edofre\NsApi\Responses;

use SimpleXMLElement;

/**
 * Class TravelPossibility
 * @package Edofre\NsApi\Responses
 */
class TravelPossibility
{
    /** @var  Announcement|null */
    public $announcement;
    /** @var  string */
    public $number_of_switches;
    /** @var  string */
    public $planned_travel_time;
    /** @var  string */
    public $actual_travel_time;
    /** @var  string */
    public $optimal;
    /** @var  string */
    public $planned_departure_time;
    /** @var  string */
    public $actual_departure_time;
    /** @var  string */
    public $planned_arrival_time;
    /** @var  string */
    public $actual_arrival_time;
    /** @var  string */
    public $status;
    /** @var  TravelSection[] */
    public $travel_sections = [];

    /**
     * TravelPossibility.php constructor.
     * @param $announcement
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
    function __construct($announcement, $number_of_switches, $planned_travel_time, $actual_travel_time, $optimal, $planned_departure_time, $actual_departure_time, $planned_arrival_time, $actual_arrival_time, $status, $travel_sections)
    {
        $this->announcement = $announcement;
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
     * @return TravelPossibility
     */
    public static function createFromXml(SimpleXMLElement $xml)
    {
        $announcement = null;
        if (!empty($xml->Melding)) {
            $announcement = Announcement::createFromXml($xml->Melding);
        }

        $travel_sections = [];
        if (!empty($xml->ReisDeel)) {
            foreach ($xml->ReisDeel as $travel_section) {
                $travel_sections[] = TravelSection::createFromXml($travel_section);
            }
        }

        return new self(
            $announcement,
            (string)$xml->AantalOverstappen,
            (string)$xml->GeplandeReisTijd,
            (string)$xml->ActueleReisTijd,
            (string)$xml->Optimaal,
            (string)$xml->GeplandeVertrekTijd,
            (string)$xml->ActueleVertrekTijd,
            (string)$xml->GeplandeAankomstTijd,
            (string)$xml->ActueleAankomstTijd,
            (string)$xml->Status,
            $travel_sections
        );
    }
}