<?php

namespace Edofre\NsApi\Responses;

use SimpleXMLElement;

/**
 * Class DepartingTrain
 * @package Edofre\NsApi\Responses
 */
class DepartingTrain
{
    /** @var  string */
    public $ride_number;
    /** @var  string */
    public $departure_time;
    /** @var */
    public $departure_delay;
    /** @var */
    public $departure_delay_title;
    /** @var  string */
    public $final_destination;
    /** @var  string */
    public $train_type;
    /** @var  string */
    public $route_text;
    /** @var  string */
    public $carrier;
    /** @var  string */
    public $track;
    /** @var  boolean */
    public $track_changed = false;
    /** @var  string */
    public $travel_tip;

    /**
     * DepartingTrain constructor.
     * @param $ride_number
     * @param $departure_time
     * @param $departure_delay
     * @param $departure_delay_title
     * @param $final_destination
     * @param $train_type
     * @param $route_text
     * @param $carrier
     * @param $track
     * @param $track_changed
     * @param $travel_tip
     */
    function __construct($ride_number, $departure_time, $departure_delay, $departure_delay_title, $final_destination, $train_type, $route_text, $carrier, $track, $track_changed, $travel_tip)
    {
        $this->code = $ride_number;
        $this->departure_time = $departure_time;
        $this->departure_delay = $departure_delay;
        $this->departure_delay_title = $departure_delay_title;
        $this->final_destination = $final_destination;
        $this->train_type = $train_type;
        $this->route_text = $route_text;
        $this->carrier = $carrier;
        $this->track = $track;
        $this->track_changed = $track_changed;
        $this->travel_tip = $travel_tip;
    }

    /**
     * @param SimpleXMLElement $xml
     * @return DepartingTrain
     */
    public static function createFromXml(SimpleXMLElement $xml)
    {
        return new self(
            (string)$xml->RitNummer,
            (string)$xml->VertrekTijd,
            (string)$xml->VertrekVertraging,
            (string)$xml->VertrekVertragingTekst,
            (string)$xml->EindBestemming,
            (string)$xml->TreinSoort,
            (string)$xml->RouteTekst,
            (string)$xml->Vervoerder,
            (string)$xml->VertrekSpoor,
            (string)$xml->VertrekSpoor['wijziging'] == 'false' ? false : true,
            (string)$xml->ReisTip
        );
    }
}