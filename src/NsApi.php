<?php

namespace Edofre\NsApi;

use GuzzleHttp\Client;

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
     * @param $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function makeRequest($request)
    {
        return $this->client->get($request, [
            'auth' => [
                $this->username,
                $this->password,
            ],
        ]);
    }
}