<?php

namespace Edofre\NsApi;

use GuzzleHttp\Client;

/**
 * Class NsApi
 * @package Edofre\NsApi
 */
class NsApi extends Client
{
    /** API URL */
    const API_URL = 'http://webservices.ns.nl/';
    /** Endpoints */
    const ENDPOINT_STATIONS = '/ns-api-stations-v2';
    /** @var Client */
    private $client;
    /** @var   */
    private $username;
    /** @var   */
    private $password;

}