<?php

namespace Edofre\NsApi\Facades;

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
        return 'laravel-ns-api';
    }
}