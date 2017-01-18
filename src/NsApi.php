<?php

namespace Edofre\NsApi;

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
    /** HTTP STATUS CODES */
    const HTTP_SUCCESS = 200;

    /** @var Client */
    private $client;
    /** @var */
    private $username;
    /** @var */
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
}