# Laravel NS API wrapper

[![Latest Stable Version](https://poser.pugx.org/edofre/laravel-ns-api/v/stable)](https://packagist.org/packages/edofre/laravel-ns-api)
[![Total Downloads](https://poser.pugx.org/edofre/laravel-ns-api/downloads)](https://packagist.org/packages/edofre/laravel-ns-api)
[![Latest Unstable Version](https://poser.pugx.org/edofre/laravel-ns-api/v/unstable)](https://packagist.org/packages/edofre/laravel-ns-api)
[![License](https://poser.pugx.org/edofre/laravel-ns-api/license)](https://packagist.org/packages/edofre/laravel-ns-api)
[![composer.lock](https://poser.pugx.org/edofre/laravel-ns-api/composerlock)](https://packagist.org/packages/edofre/laravel-ns-api)

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

To install, either run

```
$ php composer.phar require edofre/laravel-ns-api
```

or add

```
"edofre/laravel-ns-api": "v1.0.0"
```

to the ```require``` section of your `composer.json` file.

## Configuration

Publish assets and configuration files
```
php artisan vendor:publish --tag=config
```

In the above configuration file you will need to enter your NS API username and password

### Example

#### Get all the stations
```php
$api = new NsApi();
$stations = $api->getStations();
```

#### Get all the departing trains from a station
```php
$api = new NsApi();
$station = new Station('UT', '','','','','','','','','');
$departing_trains = $api->getDepartures($station);
```

#### Get all the disturbances from a station
```php
$api = new NsApi();
$station = new Station('ut', '', '', '', '', '', '', '', '', '');
// We want the actual disturbances and not the unplanned disturbances
$disturbances = $api->getDisturbances($station, true , false);
```

#### Get the prices for a route
```php
$api = new NsApi();
$from_station = new Station('ZL', '', '', '', '', '', '', '', '', '');
$via_station = new Station('DH', '', '', '', '', '', '', '', '', '');
$to_station = new Station('HT', '', '', '', '', '', '', '', '', '');
$prices = $api->getPrices($from_station, $to_station, $via_station);
```
