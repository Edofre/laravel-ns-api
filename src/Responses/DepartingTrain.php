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
     * @param $final_destination
     * @param $train_type
     * @param $route_text
     * @param $carrier
     * @param $track
     * @param $track_changed
     * @param $travel_tip
     */
    function __construct($ride_number, $departure_time, $final_destination, $train_type, $route_text, $carrier, $track, $track_changed, $travel_tip)
    {
        $this->code = $ride_number;
        $this->departure_time = $departure_time;
        $this->final_destination = $final_destination;
        $this->train_type = $train_type;
        $this->route_text = $route_text;
        $this->carrier = $carrier;
        $this->track = $track;
        $this->track_changed = $track_changed;
        $this->travel_tip = $travel_tip;
    }
}