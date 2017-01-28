<?php

namespace Edofre\NsApi;

use Edofre\NsApi\Responses\CarrierChoice;
use Edofre\NsApi\Responses\DepartingTrain;
use Edofre\NsApi\Responses\Disturbance;
use Edofre\NsApi\Responses\Station;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

/**
 * Class NsApi
 * @package Edofre\NsApi
 */
class NsApi
{
    /** API URL */
    const API_URL = 'http://webservices.ns.nl/';
    /** Endpoints */
    const ENDPOINT_DEPARTURES = '/ns-api-avt';
    const ENDPOINT_DISTURBANCES = '/ns-api-storingen';
    const ENDPOINT_STATIONS = '/ns-api-stations-v2';
    const ENDPOINT_ADVICE = '/ns-api-treinplanner';
    const ENDPOINT_PRICES = '/ns-api-prijzen-v3';
    /** HTTP STATUS CODES */
    const HTTP_SUCCESS = 200;

    /** @var  Client */
    private $client;
    /** @var  string */
    private $username;
    /** @var  string */
    private $password;

    /**
     * NsApi constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->client = new Client(array_merge([
            'base_uri' => self::API_URL,
        ], $config));

        // Make sure we have a username and password
        $this->username = config('ns-api.username');
        $this->password = config('ns-api.password');
    }

    /**
     * @return Collection
     */
    public function getStations()
    {
        $stations = new Collection();
        $result = $this->makeRequest(self::ENDPOINT_STATIONS);

        if ($result->getStatusCode() == self::HTTP_SUCCESS) {
            $xml = simplexml_load_string($result->getBody()->getContents());
            foreach ($xml as $xml_item) {
                $stations->push(Station::createFromXml($xml_item));
            }
        }

        return $stations;
    }

    /**
     * @param       $request
     * @param array $options
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function makeRequest($request, $options = [])
    {
        $options = array_merge(
            $options,
            [
                'auth' => [
                    $this->username,
                    $this->password,
                ],
            ]
        );
        return $this->client->get($request, $options);
    }

    /**
     * @param Station $station
     * @return Collection
     */
    public function getDepartures(Station $station)
    {
        $departing_trains = new Collection();
        $result = $this->makeRequest(self::ENDPOINT_DEPARTURES, [
            'query' => [
                'station' => $station->code,
            ],
        ]);

        if ($result->getStatusCode() == self::HTTP_SUCCESS) {
            $xml = simplexml_load_string($result->getBody()->getContents());
            foreach ($xml as $xml_item) {
                $departing_trains->push(DepartingTrain::createFromXml($xml_item));
            }
        }

        return $departing_trains;
    }

    /**
     * @param Station $station
     * @param boolean $actual
     * @param boolean $unplanned
     * @return Collection
     */
    public function getDisturbances(Station $station, $actual = null, $unplanned = null)
    {
        $departing_trains = new Collection();

        $request_options = [
            'query' => [
                'station' => $station->code,
            ],
        ];

        if (!is_null($actual)) {
            $request_options['query']['actual'] = ($actual) ? 'true' : 'false';
        }
        if (!is_null($unplanned)) {
            $request_options['query']['unplanned'] = ($unplanned) ? 'true' : 'false';
        }

        $result = $this->makeRequest(self::ENDPOINT_DISTURBANCES, $request_options);

        if ($result->getStatusCode() == self::HTTP_SUCCESS) {
            $xml = simplexml_load_string($result->getBody()->getContents());

            foreach ($xml->Ongepland as $xml_item) {
                foreach ($xml_item->Storing as $xml_disturbance_item) {
                    $departing_trains->push(Disturbance::createFromXml($xml_disturbance_item, false));
                }
            }
            foreach ($xml->Gepland as $xml_item) {
                foreach ($xml_item->Storing as $xml_disturbance_item) {
                    $departing_trains->push(Disturbance::createFromXml($xml_disturbance_item, true));
                }
            }
        }

        return $departing_trains;
    }

    /**
     * @param Station      $from_station
     * @param Station      $to_station
     * @param Station|null $via_station
     * @param int          $previous_advices
     * @param int          $next_advices
     * @param null         $datetime
     * @param bool         $departure
     * @param bool         $hsl_allowed
     * @param bool         $year_card
     * @return Collection
     */
    public function getAdvice(Station $from_station, Station $to_station, Station $via_station = null, $previous_advices = 5, $next_advices = 5, $datetime = null, $departure = true, $hsl_allowed = true, $year_card = false)
    {
        $advices = new Collection();

        $request_options = [
            'query' => [
                'fromStation'     => $from_station->code,
                'toStation'       => $to_station->code,
                'previousAdvices' => $previous_advices,
                'nextAdvices'     => $next_advices,
                'departure'       => ($departure) ? 'true' : 'false',
                'hslAllowed'      => ($hsl_allowed) ? 'true' : 'false',
                'yearCard'        => ($year_card) ? 'true' : 'false',
            ],
        ];

        if (!is_null($via_station)) {
            $request_options['query']['viaStation'] = $via_station->code;
        }

        if (!is_null($datetime)) {
            $request_options['query']['dateTime'] = $datetime;
        }

        $result = $this->makeRequest(self::ENDPOINT_DISTURBANCES, $request_options);

        if ($result->getStatusCode() == self::HTTP_SUCCESS) {
            $xml = simplexml_load_string($result->getBody()->getContents());

            foreach ($xml->Ongepland as $xml_item) {
                $advices->push(Advice::createFromXml($xml_item));
            }
        }

        return $advices;
    }

    /**
     * @param Station      $from_station
     * @param Station      $to_station
     * @param Station|null $via_station
     * @param int          $datetime
     * @return Collection
     */
    public function getPrices(Station $from_station, Station $to_station, Station $via_station = null, $datetime = null)
    {
        $advices = new Collection();

        $request_options = [
            'query' => [
                'fromStation'     => $from_station->code,
                'toStation'       => $to_station->code,
            ],
        ];

        if (!is_null($via_station)) {
            $request_options['query']['viaStation'] = $via_station->code;
        }

        if (!is_null($datetime)) {
            $request_options['query']['dateTime'] = $datetime;
        }

        $result = $this->makeRequest(self::ENDPOINT_PRICES, $request_options);

        if ($result->getStatusCode() == self::HTTP_SUCCESS) {
            $xml = simplexml_load_string($result->getBody()->getContents());
            foreach ($xml->Ongepland as $xml_item) {
                $advices->push(CarrierChoice::createFromXml($xml_item));
            }
        }

        return $advices;
    }
}