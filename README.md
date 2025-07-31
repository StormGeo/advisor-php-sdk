# PHP SDK

Advisor Software Development Kit for PHP.

## Contents
- [PHP SDK](#php-sdk)
  - [How to get your token](https://www.climatempoconsultoria.com.br/contato/)
  - [Contents](#contents)
  - [Installation](#installation)
  - [Routes](#routes)
    - [Examples](#examples)
      - [Chart:](#chart)
      - [Climatology:](#climatology)
      - [Current Weather:](#current-weather)
      - [Forecast:](#forecast)
      - [Monitoring:](#monitoring)
      - [Observed:](#observed)
      - [Plan Information:](#plan-information)
      - [Schema/Parameter:](#schemaparameter)
      - [Static Map:](#static-map)
      - [Storage:](#storage)
      - [Tms (Tiles Map Server):](#tms-tiles-map-server)
  - [Headers Configuration](#headers-configuration)
  - [Response Format](#response-format)
  - [Payload Types](#payload-types)
    - [WeatherPayload](#weatherpayload)
    - [StationPayload](#stationpayload)
    - [ClimatologyPayload](#climatologypayload)
    - [CurrentWeatherPayload](#currentweatherpayload)
    - [RadiusPayload](#radiuspayload)
    - [GeometryPayload](#geometrypayload)
    - [TmsPayload](#tmspayload)
    - [PlanInfoPayload](#planinfopayload)
    - [RequestDetailsPayload](#requestdetailspayload)
    - [StorageListPayload](#storagelistpayload)
    - [StorageDownloadPayload](#storagedownloadpayload)
    - [StaticMapPayload](#staticmappayload)
---

## Installation

To install this package, use the following command:

```bash
composer require stormgeo/advisorcore
```

Make sure you're using php 7 or higher. Using earlier php versions may result in unexpected behavior or incompatibilities.

## Routes

First you need to import the SDK on your application and instancy the `AdvisorCore` class setting up your access token and needed configurations:

```php
require './vendor/autoload.php';

use StormGeo\AdvisorCore\AdvisorCore;

$advisor = new AdvisorCore('<your-token>');
```

### Examples

#### Chart:
```php
use StormGeo\AdvisorCore\Payloads\WeatherPayload;

$payload = new WeatherPayload([
  'localeId' => 3477,
  'variables' => ['temperature', 'precipitation']
]);

// requesting daily forecast chart image
$response = $advisor->chart->getForecastDaily($payload);

// requesting hourly forecast chart image
$response = $advisor->chart->getForecastHourly($payload);

// requesting daily observed chart image
$response = $advisor->chart->getObservedDaily($payload);

// requesting hourly observed chart image
$response = $advisor->chart->getObservedHourly($payload);

if (is_null($response->error)) {
  $file = fopen('chart.png', 'wb');
  fwrite($file, $response->data);
  fclose($file);
} else {
  print_r($response->error);
}
```


#### Climatology:
```php
use StormGeo\AdvisorCore\Payloads\ClimatologyPayload;

$climatologyPayload = new ClimatologyPayload([
  'localeId' => 3477,
  'variables' => ['precipitation']
]);

// requesting daily climatology data
$response = $advisor->climatology->getDaily($climatologyPayload);

// requesting monthly climatology data
$response = $advisor->climatology->getMonthly($climatologyPayload);


if (is_null($response->error)) {
  print_r($response->data);
} else {
  print_r('Error trying to get data!');
  print_r($response->error);
}
```


#### Current Weather:
```php
use StormGeo\AdvisorCore\Payloads\CurrentWeatherPayload;

$payload = new CurrentWeatherPayload([
  'localeId' => 3477,
  'variables' => ['temperature', 'precipitation']
]);

$response = $advisor->currentWeather->get($payload);

if (is_null($response->error)) {
  print_r($response->data);
} else {
  print_r('Error trying to get data!');
  print_r($response->error);
}
```


#### Forecast:
```php
use StormGeo\AdvisorCore\Payloads\WeatherPayload;

$payload = new WeatherPayload([
  'localeId' => 3477,
  'variables' => ['temperature', 'precipitation']
]);

// requesting daily forecast data
$response = $advisor->forecast->getDaily($payload);

// requesting hourly forecast data
$response = $advisor->forecast->getHourly($payload);

// requesting period forecast data
$response = $advisor->forecast->getPeriod($payload);

if (is_null($response->error)) {
  print_r($response->data);
} else {
  print_r('Error trying to get data!');
  print_r($response->error);
}
```


#### Monitoring:
```php
$response = $advisor->monitoring->getAlerts();

if (is_null($response->error)) {
  print_r($response->data);
} else {
  print_r('Error trying to get data!');
  print_r($response->error);
}
```


#### Observed:
```php
use StormGeo\AdvisorCore\Payloads\WeatherPayload;
use StormGeo\AdvisorCore\Payloads\GeometryPayload;
use StormGeo\AdvisorCore\Payloads\RadiusPayload;
use StormGeo\AdvisorCore\Payloads\StationPayload;

$payload = new WeatherPayload([
  'localeId' => 3477,
  'variables' => ['temperature', 'precipitation']
]);

// requesting daily observed data
$response = $advisor->observed->getDaily($payload);

// requesting hourly observed data
$response = $advisor->observed->getHourly($payload);

// requesting period observed data
$response = $advisor->observed->getPeriod($payload);


$stationPayload = new StationPayload([
  'stationId' => 'bWV0b3M6MDEyMEM5RkU6LTIzLjkzMDY4NDotNDYuNDg4NTQ4'
]);

// requesting station observed data
$response = $advisor->observed->getStationData($stationPayload);


$radiusPayload = new RadiusPayload([
  'localeId' => 3477,
  'radius' => 10000
]);

// requesting fire-focus observed data
$response = $advisor->observed->getFireFocus($radiusPayload);

// requesting lightning observed data
$response = $advisor->observed->getLightning($radiusPayload);


$geometryPayload = new GeometryPayload([
  'startDate' => '2024-11-28 00:00:00',
  'endDate' => '2024-11-28 12:59:59',
  'geometry' => '{"type": "MultiPoint", "coordinates": [[-41.88, -22.74]]}'
]);

// requesting fire-focus observed data by geometry
$response = $advisor->observed->getFireFocusByGeometry($geometryPayload);

// requesting lightning observed data by geometry
$response = $advisor->observed->getLightningByGeometry($geometryPayload);

if (is_null($response->error)) {
  print_r($response->data);
} else {
  print_r('Error trying to get data!');
  print_r($response->error);
}
```

#### Plan Information:
```php
$payload = new PlanInfoPayload([
  'timezone' => -3  # default timezone is 0 (UTC)
]);

$payloadForRequestDetails = new RequestDetailsPayload([
  'page' => 1,
  'pageSize' => 3
]);

// requesting plan information
$response = $advisor->plan->getInfo($payload);

// requesting access history
$response = $advisor->plan->getRequestDetails($payloadForRequestDetails)

if (is_null($response->error)) {
  print_r($response->data);
} else {
  print_r('Error trying to get data!');
  print_r($response->error);
}
```

#### Schema/Parameter:
```php
// Arbitrary example on how to define a schema
$schemaPayload = [
  'identifier' => 'arbitraryIdentifier',
  'arbitraryField1' => [
    'type' => 'string',
    'required' => 'true',
    'length' => 125,
  ],
];

// Arbitrary example on how to upload data to parameters from schema 
$parametersPayload = [
  'identifier' => 'arbitraryIdentifier',
  'arbitraryField1' => 'some text',
];

// requesting all schemas from token
$response = $advisor->schema->getDefinition();

// requesting to upload a new schema
$response = $advisor->schema->postDefinition($schemaPayload);

// requesting to upload data to parameters from schema
$response = $advisor->schema->postParameters($parametersPayload);

if (is_null($response->error)) {
  print_r($response->data);
} else {
  print_r('Error trying to get data!');
  print_r($response->error);
}
```

#### Static Map:
```php
$payload = new StaticMapPayload([
  'startDate' => '2025-07-21 00:00:00',
  'endDate' => '2025-07-25 23:59:59',
  'aggregation' => 'sum',
  'dpi' => 100,
  'title' => 'true',
  'titlevariable' => 'precipitation',
  'type' => 'periods',
  'category' => 'observed',
  'variable' => 'precipitation'
]);

$response = $advisor->staticMap->get_static_map($payload);

if (is_null($response->error)) {
  $file = fopen('staticMap.png', 'wb');
  fwrite($file, $response->data);
  fclose($file);
} else {
  print_r('Error trying to get data!');
  print_r($response->error);
}
```

#### Storage:
```php
$payloadForListing = new StorageListPayload([
  'page' => 1,
  'pageSize' => 5
]);

$payloadForDownload = new StorageDownloadPayload([
  'fileName' => 'Example.pdf',
  'accessKey' => 'a1b2c3d4-0010'
]);

# requesting the files list
$response = $advisor->storage->listFiles($payloadForListing);

if (is_null($response->error)) {
  print_r($response->data);
} else {
  print_r("Error trying to get data!");
  print_r($response->error);
}

# downloading a file from the list
$response = $advisor->storage->downloadFile($payloadForDownload);

if (is_null($response->error)) {
  $file = fopen("$payloadForDownload->fileName", 'wb');
  fwrite($file, $response->data);
  fclose($file);
} else {
  print_r("Error trying to get file!");
  print_r($response->error);
}

# downloading a file by stream
$response = $advisor->storage->downloadFileByStream($downloadPayload);

if (is_null($response->error)) {
  $file = fopen("$payloadForDownload->fileName", 'wb');
  if (is_resource($response->data)) {
    stream_copy_to_stream($response->data, $file);
  } else {
    fwrite($file, $response->data);
  }
  fclose($file);
} else {
  print_r("Error trying to get file!");
  print_r($response->error);
}
```

#### Tms (Tiles Map Server):
```php
use StormGeo\AdvisorCore\Payloads\TmsPayload;

$payload = new TmsPayload([
  'istep' => '2025-01-24 10:00:00',
  'fstep' => '2025-01-25 12:00:00',
  'server' => 'a',
  'mode' => 'forecast',
  'variable' => 'precipitation',
  'aggregation' => 'sum',
  'x' => 2,
  'y' => 3,
  'z' => 4,
  'timezone' => -3  # default timezone is 0 (UTC)
]);

$response = $advisor->tms->get($payload);

if (is_null($response->error)) {
  $file = fopen('tile.png', 'wb');
  fwrite($file, $response->data);
  fclose($file);
} else {
  print_r($response);
}
```

## Headers Configuration

You can also set headers to translate the error descriptions or to receive the response in a different format type. This functionality is only available for some routes, consult the API documentation to find out which routes have this functionality.

Available languages: 
- en-US (default)
- pt-BR
- es-ES

Available response types:
- application/json (default)
- application/xml
- text/csv

Example:

```php
use StormGeo\AdvisorCore\AdvisorCore;

$advisor = new AdvisorCore('invalid-token');

$advisor->setHeaderAccept('application/xml');
$advisor->setHeaderAcceptLanguage('es-ES');

$response = $advisor->plan->getInfo();

print_r($response->error);

// <response>
//   <error>
//     <type>UNAUTHORIZED_ACCESS</type>
//     <message>UNAUTHORIZED_REQUEST</message>
//     <description>La solicitud no está autorizada.</description>
//   </error>
// </response>
```


## Response Format

All the methods returns the same pattern:

```php
{
  "data": array|string|null,
  "error": array|string|null,
}
```

## Payload Types

### WeatherPayload

- **localeId**: string
- **stationId**: string
- **latitude**: float
- **longitude**: float
- **timezone**: int
- **variables**: array<string>
- **startDate**: string
- **endDate**: string

### StationPayload

- **stationId**: string
- **layer**: string
- **variables**: array<string>
- **startDate**: string
- **endDate**: string

### ClimatologyPayload

- **localeId**: string
- **stationId**: string
- **latitude**: float
- **longitude**: float
- **variables**: array<string>

### CurrentWeatherPayload

- **localeId**: string
- **stationId**: string
- **latitude**: float
- **longitude**: float
- **timezone**: int
- **variables**: array<string>

### RadiusPayload

- **localeId**: string
- **stationId**: string
- **latitude**: float
- **longitude**: float
- **startDate**: string
- **endDate**: string
- **radius**: int

### GeometryPayload

- **startDate**: string
- **endDate**: string
- **radius**: int
- **geometry**: string

### TmsPayload

- **server**: string
- **mode**: string
- **variable**: string
- **aggregation**: string
- **x**: int
- **y**: int
- **z**: int
- **istep**: string
- **fstep**: string
- **timezone**: int

### PlanInfoPayload

- **timezone**: int

### RequestDetailsPayload

- **page**: int
- **pageSize**: int
- **path**: string
- **status**: string
- **startDate**: string
- **endDate**: string

### StorageListPayload

- **page**: int
- **pageSize**: int
- **startDate**: string
- **endDate**: string
- **fileName**: string
- **fileExtension**: string

### StorageDownloadPayload

- **fileName**: string
- **accessKey**: string

### StaticMapPayload

- **startate**: string
- **endDate**: string
- **aggregation**: string
- **model**: string
- **lonmin**: float
- **latmin**: float
- **lonmax**: float
- **latmax**: float
- **dpi**: int
- **title**: bool
- **titlevariable**: string
- **hours**: int
- **type**: string
- **category**: string
- **variable**: string
