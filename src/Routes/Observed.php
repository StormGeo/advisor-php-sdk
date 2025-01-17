<?php

namespace StormGeo\AdvisorCore\Routes;

use StormGeo\AdvisorCore\Payloads\WeatherPayload;
use StormGeo\AdvisorCore\Payloads\GeometryPayload;
use StormGeo\AdvisorCore\Payloads\StationPayload;
use StormGeo\AdvisorCore\Payloads\RadiusPayload;

/**
 * @package StormGeo\AdvisorCore
 */
class Observed extends BaseRouter
{
  /**
   * GET /v1/observed/daily
   * 
   * @param   WeatherPayload $payload
   * @return  AdvisorResponse
   */
  public function getDaily($payload)
  {
    return parent::makeRequest(
      'GET',
      '/v1/observed/daily' . $this->formatQueryParams($payload->getQueryParams())
    );
  }

  /**
   * GET /v1/observed/hourly
   * 
   * @param   WeatherPayload $payload
   * @return  AdvisorResponse
   */
  public function getHourly($payload)
  {
    return parent::makeRequest(
      'GET',
      '/v1/observed/hourly' . $this->formatQueryParams($payload->getQueryParams())
    );
  }

  /**
   * GET /v1/observed/period
   * 
   * @param   WeatherPayload $payload
   * @return  AdvisorResponse
   */
  public function getPeriod($payload)
  {
    return parent::makeRequest(
      'GET',
      '/v1/observed/period' . $this->formatQueryParams($payload->getQueryParams())
    );
  }

  /**
   * GET /v1/observed/lightning
   * 
   * @param   RadiusPayload $payload
   * @return  AdvisorResponse
   */
  public function getLightning($payload)
  {
    return parent::makeRequest(
      'GET',
      '/v1/observed/lightning' . $this->formatQueryParams($payload->getQueryParams())
    );
  }

  /**
   * POST /v1/observed/lightning
   * 
   * @param   GeometryPayload $payload
   * @return  AdvisorResponse
   */
  public function getLightningByGeometry($payload)
  {
    return parent::makeRequest(
      'POST',
      '/v1/observed/lightning' . $this->formatQueryParams($payload->getQueryParams()),
      $payload->getBody()
    );
  }

  /**
   * GET /v1/observed/fire-focus
   * 
   * @param   RadiusPayload $payload
   * @return  AdvisorResponse
   */
  public function getFireFocus($payload)
  {
    return parent::makeRequest(
      'GET',
      '/v1/observed/fire-focus' . $this->formatQueryParams($payload->getQueryParams())
    );
  }

  /**
   * POST /v1/observed/fire-focus
   * 
   * @param   GeometryPayload $payload
   * @return  AdvisorResponse
   */
  public function getFireFocusByGeometry($payload)
  {
    return parent::makeRequest(
      'POST',
      '/v1/observed/fire-focus' . $this->formatQueryParams($payload->getQueryParams()),
      $payload->getBody()
    );
  }

  /**
   * GET /v1/station
   * 
   * @param   StationPayload $payload
   * @return  AdvisorResponse
   */
  public function getStationData($payload)
  {
    return parent::makeRequest(
      'GET',
      '/v1/station' . $this->formatQueryParams($payload->getQueryParams())
    );
  }
}
