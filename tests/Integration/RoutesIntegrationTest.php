<?php

namespace StormGeo\AdvisorCore\Tests\Integration;

use PHPUnit\Framework\TestCase;

class RoutesIntegrationTest extends TestCase
{
  /**
   * @return bool
   */
  public function testIntegrationSetupRequiresSharedAdvisorEnv()
  {
    $missingRequiredEnv = IntegrationHelpers::getMissingRequiredEnv();

    $this->assertSame(
      [],
      $missingRequiredEnv,
      IntegrationHelpers::getMissingRequiredEnvMessage()
    );

    return true;
  }

  /**
   * @depends testIntegrationSetupRequiresSharedAdvisorEnv
   */
  public function testForecastRoutes()
  {
    $advisor = IntegrationHelpers::createAdvisor();
    $payloads = IntegrationHelpers::createPayloads();

    foreach (['getDaily', 'getHourly', 'getPeriod'] as $methodName) {
      IntegrationHelpers::assertJsonSuccess(
        $advisor->forecast->$methodName($payloads['weatherPayload'])
      );
    }
  }

  /**
   * @depends testIntegrationSetupRequiresSharedAdvisorEnv
   */
  public function testObservedWeatherRoutes()
  {
    $advisor = IntegrationHelpers::createAdvisor();
    $payloads = IntegrationHelpers::createPayloads();

    foreach (['getDaily', 'getHourly', 'getPeriod'] as $methodName) {
      IntegrationHelpers::assertJsonSuccess(
        $advisor->observed->$methodName($payloads['weatherPayload'])
      );
    }
  }

  /**
   * @depends testIntegrationSetupRequiresSharedAdvisorEnv
   */
  public function testObservedStationData()
  {
    $advisor = IntegrationHelpers::createAdvisor();
    $payloads = IntegrationHelpers::createPayloads();

    IntegrationHelpers::assertJsonSuccess(
      $advisor->observed->getStationData($payloads['stationPayload'])
    );
  }

  /**
   * @depends testIntegrationSetupRequiresSharedAdvisorEnv
   */
  public function testObservedRadiusRoutes()
  {
    $advisor = IntegrationHelpers::createAdvisor();
    $payloads = IntegrationHelpers::createPayloads();

    IntegrationHelpers::assertJsonSuccess(
      $advisor->observed->getFireFocus($payloads['radiusPayload'])
    );
    IntegrationHelpers::assertJsonSuccess(
      $advisor->observed->getLightning($payloads['radiusPayload'])
    );
    IntegrationHelpers::assertJsonSuccess(
      $advisor->observed->getLightningDetails($payloads['lightningDetailsPayload'])
    );
  }

  /**
   * @depends testIntegrationSetupRequiresSharedAdvisorEnv
   */
  public function testObservedGeometryRoutes()
  {
    $advisor = IntegrationHelpers::createAdvisor();
    $payloads = IntegrationHelpers::createPayloads();

    IntegrationHelpers::assertJsonSuccess(
      $advisor->observed->getFireFocusByGeometry($payloads['geometryPayload'])
    );
    IntegrationHelpers::assertJsonSuccess(
      $advisor->observed->getLightningByGeometry($payloads['geometryPayload'])
    );
  }

  /**
   * @depends testIntegrationSetupRequiresSharedAdvisorEnv
   */
  public function testObservedLightningLite()
  {
    $advisor = IntegrationHelpers::createAdvisor();
    $payloads = IntegrationHelpers::createPayloads();

    IntegrationHelpers::assertJsonSuccess(
      $advisor->observed->getLightningLite($payloads['lightningLitePayload'])
    );
  }

  /**
   * @depends testIntegrationSetupRequiresSharedAdvisorEnv
   */
  public function testCurrentWeather()
  {
    $advisor = IntegrationHelpers::createAdvisor();
    $payloads = IntegrationHelpers::createPayloads();

    IntegrationHelpers::assertJsonSuccess(
      $advisor->currentWeather->get($payloads['currentWeatherPayload'])
    );
  }

  /**
   * @depends testIntegrationSetupRequiresSharedAdvisorEnv
   */
  public function testClimatologyRoutes()
  {
    $advisor = IntegrationHelpers::createAdvisor();
    $payloads = IntegrationHelpers::createPayloads();

    foreach (['getDaily', 'getMonthly'] as $methodName) {
      IntegrationHelpers::assertJsonSuccess(
        $advisor->climatology->$methodName($payloads['climatologyPayload'])
      );
    }
  }

  /**
   * @depends testIntegrationSetupRequiresSharedAdvisorEnv
   */
  public function testMonitoringAlerts()
  {
    $advisor = IntegrationHelpers::createAdvisor();

    IntegrationHelpers::assertJsonSuccess($advisor->monitoring->getAlerts());
  }

  /**
   * @depends testIntegrationSetupRequiresSharedAdvisorEnv
   */
  public function testStationsLastData()
  {
    $advisor = IntegrationHelpers::createAdvisor();
    $payloads = IntegrationHelpers::createPayloads();

    IntegrationHelpers::assertJsonSuccess(
      $advisor->stations->getLastData($payloads['stationsLastDataPayload'])
    );
  }

  /**
   * @depends testIntegrationSetupRequiresSharedAdvisorEnv
   */
  public function testPlanRoutes()
  {
    $advisor = IntegrationHelpers::createAdvisor();
    $payloads = IntegrationHelpers::createPayloads();

    IntegrationHelpers::assertJsonSuccess($advisor->plan->getInfo($payloads['planInfoPayload']));
    IntegrationHelpers::assertJsonSuccess($advisor->plan->getRequestDetails($payloads['requestDetailsPayload']));
    IntegrationHelpers::assertJsonSuccess($advisor->plan->getLocale($payloads['planLocalePayload']));
  }

  /**
   * @depends testIntegrationSetupRequiresSharedAdvisorEnv
   */
  public function testChartRoutes()
  {
    $advisor = IntegrationHelpers::createAdvisor();
    $payloads = IntegrationHelpers::createPayloads();

    foreach (['getForecastDaily', 'getForecastHourly', 'getObservedDaily', 'getObservedHourly'] as $methodName) {
      IntegrationHelpers::assertBinarySuccess(
        $advisor->chart->$methodName($payloads['weatherChartPayload'])
      );
    }
  }

  /**
   * @depends testIntegrationSetupRequiresSharedAdvisorEnv
   */
  public function testStorageRoutes()
  {
    $advisor = IntegrationHelpers::createAdvisor();
    $payloads = IntegrationHelpers::createPayloads();
    $downloadPayload = IntegrationHelpers::resolveStorageDownloadPayload();

    IntegrationHelpers::assertJsonSuccess($advisor->storage->listFiles($payloads['storageListPayload']));
    IntegrationHelpers::assertBinarySuccess($advisor->storage->downloadFile($downloadPayload));
    IntegrationHelpers::assertStreamSuccess($advisor->storage->downloadFileByStream($downloadPayload));
  }

  /**
   * @depends testIntegrationSetupRequiresSharedAdvisorEnv
   */
  public function testStaticMap()
  {
    $advisor = IntegrationHelpers::createAdvisor();
    $payloads = IntegrationHelpers::createPayloads();

    IntegrationHelpers::assertBinarySuccess(
      $advisor->staticMap->getStaticMap($payloads['staticMapPayload'])
    );
  }

  /**
   * @depends testIntegrationSetupRequiresSharedAdvisorEnv
   */
  public function testTms()
  {
    $advisor = IntegrationHelpers::createAdvisor();
    $payloads = IntegrationHelpers::createPayloads();

    IntegrationHelpers::assertBinarySuccess($advisor->tms->get($payloads['tmsPayload']));
  }

  /**
   * @depends testIntegrationSetupRequiresSharedAdvisorEnv
   */
  public function testPmtiles()
  {
    $advisor = IntegrationHelpers::createAdvisor();
    $payloads = IntegrationHelpers::createPayloads();

    IntegrationHelpers::assertBinarySuccess($advisor->pmtiles->get($payloads['pmtilesPayload']));
  }

  /**
   * @depends testIntegrationSetupRequiresSharedAdvisorEnv
   */
  public function testSchemaRoutes()
  {
    $advisor = IntegrationHelpers::createAdvisor();
    $payloads = IntegrationHelpers::createPayloads();

    IntegrationHelpers::assertJsonSuccess($advisor->schema->getDefinition());
    IntegrationHelpers::assertJsonSuccess($advisor->schema->postDefinition($payloads['schemaDefinitionPayload']));
  }
}
