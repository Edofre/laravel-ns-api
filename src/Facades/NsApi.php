<?php

namespace Edofre\NsApi\Facades;

use Edofre\Fullcalendar\NsApiServiceProvider;
use Illuminate\Support\Facades\Facade;

/**
 * Class NsApi
 * @package Edofre\NsApi\Facades
 */
class NsApi extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return NsApiServiceProvider::IDENTIFIER;
    }
}