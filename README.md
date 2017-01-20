# WIP WIP WIP 
# Contents may be subject to change at any time
# WIP WIP WIP

# Laravel NS API

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

To install, either run

```
$ php composer.phar require edofre/laravel-ns-api
```

or add

```
"edofre/laravel-ns-api": "*"
```

to the ```require``` section of your `composer.json` file.

## Configuration

Publish assets and configuration files
```
php artisan vendor:publish --tag=config
```

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

