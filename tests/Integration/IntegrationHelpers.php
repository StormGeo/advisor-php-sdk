<?php

namespace StormGeo\AdvisorCore\Tests\Integration;

use StormGeo\AdvisorCore\AdvisorCore;
use StormGeo\AdvisorCore\Payloads\ClimatologyPayload;
use StormGeo\AdvisorCore\Payloads\CurrentWeatherPayload;
use StormGeo\AdvisorCore\Payloads\GeometryPayload;
use StormGeo\AdvisorCore\Payloads\LightningLitePayload;
use StormGeo\AdvisorCore\Payloads\PlanInfoPayload;
use StormGeo\AdvisorCore\Payloads\PlanLocalePayload;
use StormGeo\AdvisorCore\Payloads\PmtilesPayload;
use StormGeo\AdvisorCore\Payloads\RadiusPayload;
use StormGeo\AdvisorCore\Payloads\RequestDetailsPayload;
use StormGeo\AdvisorCore\Payloads\StationPayload;
use StormGeo\AdvisorCore\Payloads\StationsLastDataPayload;
use StormGeo\AdvisorCore\Payloads\StaticMapPayload;
use StormGeo\AdvisorCore\Payloads\StorageDownloadPayload;
use StormGeo\AdvisorCore\Payloads\StorageListPayload;
use StormGeo\AdvisorCore\Payloads\TmsPayload;
use StormGeo\AdvisorCore\Payloads\WeatherPayload;
use StormGeo\AdvisorCore\Routes\AdvisorResponse;

final class IntegrationEnvironment
{
  /**
   * @var bool
   */
  private static $loaded = false;

  public static function load()
  {
    if (self::$loaded) {
      return;
    }

    self::$loaded = true;

    $envFile = self::findIntegrationEnvFile(__DIR__);
    if (is_null($envFile)) {
      $envFile = self::findIntegrationEnvFile(getcwd());
    }

    if (is_null($envFile)) {
      return;
    }

    $lines = file($envFile, FILE_IGNORE_NEW_LINES);
    if ($lines === false) {
      return;
    }

    foreach ($lines as $rawLine) {
      $line = trim($rawLine);
      if ($line === '' || strpos($line, '#') === 0) {
        continue;
      }

      $separatorIndex = strpos($line, '=');
      if ($separatorIndex === false) {
        continue;
      }

      $name = trim(substr($line, 0, $separatorIndex));
      $existingValue = getenv($name);
      if ($name === '' || $existingValue !== false) {
        continue;
      }

      $value = trim(substr($line, $separatorIndex + 1));
      $length = strlen($value);
      if ($length >= 2) {
        $firstChar = $value[0];
        $lastChar = $value[$length - 1];
        $isWrappedInDoubleQuotes = $firstChar === '"' && $lastChar === '"';
        $isWrappedInSingleQuotes = $firstChar === "'" && $lastChar === "'";

        if ($isWrappedInDoubleQuotes || $isWrappedInSingleQuotes) {
          $value = substr($value, 1, -1);
        }
      }

      putenv($name . '=' . $value);
      $_ENV[$name] = $value;
      $_SERVER[$name] = $value;
    }
  }

  /**
   * @param string $startDir
   * @return string|null
   */
  private static function findIntegrationEnvFile($startDir)
  {
    if (!is_string($startDir) || $startDir === '') {
      return null;
    }

    $currentDir = realpath($startDir);
    if ($currentDir === false) {
      return null;
    }

    while (true) {
      $candidate = $currentDir . DIRECTORY_SEPARATOR . '.env.integration.local';
      if (is_file($candidate)) {
        return $candidate;
      }

      $parentDir = dirname($currentDir);
      if ($parentDir === $currentDir) {
        return null;
      }

      $currentDir = $parentDir;
    }
  }
}

final class IntegrationHelpers
{
  /**
   * @var string[]
   */
  private static $requiredEnvNames = [
    'ADVISOR_TOKEN',
    'ADVISOR_STATION_ID',
    'ADVISOR_GEOMETRY',
    'ADVISOR_STORAGE_FILE_NAME',
    'ADVISOR_STORAGE_ACCESS_KEY',
  ];

  /**
   * @return string[]
   */
  public static function getMissingRequiredEnv()
  {
    IntegrationEnvironment::load();

    $missing = [];
    foreach (self::$requiredEnvNames as $name) {
      if (!self::hasEnv($name)) {
        $missing[] = $name;
      }
    }

    return $missing;
  }

  /**
   * @return string
   */
  public static function getMissingRequiredEnvMessage()
  {
    return sprintf(
      'Set %s or add them to .env.integration.local before running the PHP integration tests.',
      implode(', ', self::getMissingRequiredEnv())
    );
  }

  /**
   * @return AdvisorCore
   */
  public static function createAdvisor()
  {
    $advisor = new AdvisorCore(self::requireEnv('ADVISOR_TOKEN'), 1, 0);
    $advisor->setHeaderAccept('application/json');
    $advisor->setHeaderAcceptLanguage(self::getEnv('ADVISOR_ACCEPT_LANGUAGE', 'en-US'));

    return $advisor;
  }

  /**
   * @return array<string,mixed>
   */
  public static function createPayloads()
  {
    $localeId = self::getEnvInt('ADVISOR_LOCALE_ID', 3477);
    $planLocaleId = self::getEnvInt('ADVISOR_PLAN_LOCALE_ID', 5959);
    $stationId = self::requireEnv('ADVISOR_STATION_ID');
    $geometry = self::requireEnv('ADVISOR_GEOMETRY');
    $today = new \DateTimeImmutable('now');
    $observedDay = $today->modify('-1 day');
    $observedPeriodEnd = $observedDay;
    $observedPeriodStart = $observedPeriodEnd->modify('-4 days');
    $forecastDay = $today->modify('+1 day');
    $forecastHourEnd = $forecastDay->setTime(1, 0, 0);
    $schemaIdentifier = 'schemaIdentifier';

    return [
      'weatherPayload' => new WeatherPayload([
        'localeId' => $localeId,
        'variables' => ['temperature'],
      ]),
      'weatherChartPayload' => new WeatherPayload([
        'localeId' => $localeId,
        'variables' => ['temperature', 'precipitation'],
      ]),
      'climatologyPayload' => new ClimatologyPayload([
        'localeId' => $localeId,
        'variables' => ['temperature'],
      ]),
      'currentWeatherPayload' => new CurrentWeatherPayload([
        'localeId' => $localeId,
      ]),
      'stationPayload' => new StationPayload([
        'stationId' => $stationId,
      ]),
      'stationsLastDataPayload' => new StationsLastDataPayload([
        'stationIds' => [$stationId],
        'variables' => ['temperature'],
      ]),
      'radiusPayload' => new RadiusPayload([
        'localeId' => $localeId,
        'radius' => 10000,
      ]),
      'geometryPayload' => new GeometryPayload([
        'geometry' => $geometry,
        'startDate' => self::startOfDay($observedDay),
        'endDate' => self::endOfDay($observedDay),
        'radius' => 10000,
      ]),
      'lightningDetailsPayload' => new RadiusPayload([
        'latitude' => '-22.9',
        'longitude' => '-43.2',
        'startDate' => self::startOfDay($observedDay),
        'endDate' => self::endOfDay($observedDay),
        'radius' => 10000,
      ]),
      'lightningLitePayload' => new LightningLitePayload([
        'geometry' => $geometry,
        'startDate' => self::startOfDay($observedPeriodStart),
        'endDate' => self::endOfDay($observedPeriodEnd),
        'radius' => 10000,
        'page' => 1,
        'pageSize' => 50,
      ]),
      'storageListPayload' => new StorageListPayload([
        'page' => 1,
        'pageSize' => 10,
      ]),
      'planInfoPayload' => new PlanInfoPayload([
        'timezone' => -3,
      ]),
      'planLocalePayload' => new PlanLocalePayload([
        'localeId' => $planLocaleId,
      ]),
      'requestDetailsPayload' => new RequestDetailsPayload([
        'page' => 1,
        'pageSize' => 3,
      ]),
      'staticMapPayload' => new StaticMapPayload([
        'type' => 'periods',
        'category' => 'observed',
        'variable' => 'temperature',
        'aggregation' => 'max',
        'startDate' => self::startOfDay($observedPeriodStart),
        'endDate' => self::endOfDay($observedPeriodEnd),
        'dpi' => 50,
        'title' => true,
        'titlevariable' => 'Static Map',
      ]),
      'tmsPayload' => new TmsPayload([
        'istep' => self::startOfDay($forecastDay),
        'fstep' => self::endOfDay($forecastDay),
        'server' => 'a',
        'mode' => 'forecast',
        'variable' => 'precipitation',
        'aggregation' => 'sum',
        'x' => 5,
        'y' => 8,
        'z' => 4,
      ]),
      'pmtilesPayload' => new PmtilesPayload([
        'mode' => 'forecast',
        'model' => 'ct2w15_as',
        'variable' => 'precipitation',
        'aggregation' => 'sum',
        'istep' => self::startOfDay($forecastDay),
        'fstep' => self::formatDateTime($forecastHourEnd),
        'maxZoom' => 4,
      ]),
      'schemaDefinitionPayload' => [
        'identifier' => $schemaIdentifier,
        'arbitraryField1' => [
          'type' => 'boolean',
          'required' => true,
          'length' => 125,
        ],
        'arbitraryField2' => [
          'type' => 'number',
          'required' => true,
        ],
        'arbitraryField3' => [
          'type' => 'string',
          'required' => false,
        ],
      ],
    ];
  }

  /**
   * @return StorageDownloadPayload
   */
  public static function resolveStorageDownloadPayload()
  {
    return new StorageDownloadPayload([
      'fileName' => self::requireEnv('ADVISOR_STORAGE_FILE_NAME'),
      'accessKey' => self::requireEnv('ADVISOR_STORAGE_ACCESS_KEY'),
    ]);
  }

  /**
   * @param AdvisorResponse $response
   * @throws \PHPUnit\Framework\ExpectationFailedException
   */
  public static function assertJsonSuccess($response)
  {
    \PHPUnit\Framework\Assert::assertInstanceOf(AdvisorResponse::class, $response);
    \PHPUnit\Framework\Assert::assertNull($response->error, self::formatError($response->error));
    \PHPUnit\Framework\Assert::assertIsArray($response->data);
  }

  /**
   * @param AdvisorResponse $response
   * @throws \PHPUnit\Framework\ExpectationFailedException
   */
  public static function assertBinarySuccess($response)
  {
    \PHPUnit\Framework\Assert::assertInstanceOf(AdvisorResponse::class, $response);
    \PHPUnit\Framework\Assert::assertNull($response->error, self::formatError($response->error));
    \PHPUnit\Framework\Assert::assertTrue(is_string($response->data));
    \PHPUnit\Framework\Assert::assertNotSame('', $response->data);
  }

  /**
   * @param AdvisorResponse $response
   * @throws \PHPUnit\Framework\ExpectationFailedException
   */
  public static function assertStreamSuccess($response)
  {
    \PHPUnit\Framework\Assert::assertInstanceOf(AdvisorResponse::class, $response);
    \PHPUnit\Framework\Assert::assertNull($response->error, self::formatError($response->error));
    \PHPUnit\Framework\Assert::assertTrue(is_resource($response->data));

    $contents = stream_get_contents($response->data);
    if (is_resource($response->data)) {
      fclose($response->data);
    }

    \PHPUnit\Framework\Assert::assertTrue(is_string($contents));
    \PHPUnit\Framework\Assert::assertNotSame('', $contents);
  }

  /**
   * @param string $name
   * @return string
   */
  private static function requireEnv($name)
  {
    $value = self::getEnv($name);
    if ($value === null || $value === '') {
      throw new \RuntimeException(
        sprintf(
          'Set %s or add it to .env.integration.local before running the PHP integration tests.',
          $name
        )
      );
    }

    return $value;
  }

  /**
   * @param string $name
   * @param int $defaultValue
   * @return int
   */
  private static function getEnvInt($name, $defaultValue)
  {
    $value = self::getEnv($name);
    if ($value === null || $value === '') {
      return $defaultValue;
    }

    return (int) $value;
  }

  /**
   * @param string $name
   * @param string|null $defaultValue
   * @return string|null
   */
  private static function getEnv($name, $defaultValue = null)
  {
    IntegrationEnvironment::load();

    $value = getenv($name);
    if ($value === false) {
      return $defaultValue;
    }

    return $value;
  }

  /**
   * @param string $name
   * @return bool
   */
  private static function hasEnv($name)
  {
    $value = self::getEnv($name);

    return !($value === null || $value === '');
  }

  /**
   * @param \DateTimeImmutable $value
   * @return string
   */
  private static function startOfDay($value)
  {
    return self::formatDateTime($value->setTime(0, 0, 0));
  }

  /**
   * @param \DateTimeImmutable $value
   * @return string
   */
  private static function endOfDay($value)
  {
    return self::formatDateTime($value->setTime(23, 59, 59));
  }

  /**
   * @param \DateTimeImmutable $value
   * @return string
   */
  private static function formatDateTime($value)
  {
    return $value->format('Y-m-d H:i:s');
  }

  /**
   * @param mixed $error
   * @return string
   */
  private static function formatError($error)
  {
    if (is_null($error) || $error === '') {
      return 'Unknown error';
    }

    if (is_string($error)) {
      return $error;
    }

    return json_encode($error);
  }
}
