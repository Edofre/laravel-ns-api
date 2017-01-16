<?php

namespace Edofre\NsApi;

use Edofre\NsApi\Responses\DepartingTrain;
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
    const ENDPOINT_STATIONS = '/ns-api-stations-v2';
    const ENDPOINT_DEPARTURES = '/ns-api-avt';
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
        $result = $this->makeRequest(self::ENDPOINT_STATIONS);
        $stations = new Collection();

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
        $result = $this->makeRequest(self::ENDPOINT_DEPARTURES, [
            'query' => [
                'station' => $station->code,
            ],
        ]);

        $departing_trains = new Collection();
        if ($result->getStatusCode() == self::HTTP_SUCCESS) {
            $xml = simplexml_load_string($result->getBody()->getContents());
            foreach ($xml as $xml_item) {
                $departing_trains->push(DepartingTrain::createFromXml($xml_item));
            }
        }

        return $departing_trains;
    }
}