<?php

namespace StormGeo\AdvisorCore\Routes;

use StormGeo\AdvisorCore\Payloads\WeatherPayload;

/**
 * @package StormGeo\AdvisorCore
 */
class Forecast extends BaseRouter
{
  /**
   * GET /v1/forecast/daily
   * 
   * @param   WeatherPayload $payload
   * @return  AdvisorResponse
   */
  public function getDaily($payload)
  {
    return parent::makeRequest(
      'GET',
      '/v1/forecast/daily' . $this->formatQueryParams($payload->getQueryParams())
    );
  }

  /**
   * GET /v1/forecast/hourly
   * 
   * @param   WeatherPayload $payload
   * @return  AdvisorResponse
   */
  public function getHourly($payload)
  {
    return parent::makeRequest(
      'GET',
      '/v1/forecast/hourly' . $this->formatQueryParams($payload->getQueryParams())
    );
  }

  /**
   * GET /v1/forecast/period
   * 
   * @param   WeatherPayload $payload
   * @return  AdvisorResponse
   */
  public function getPeriod($payload)
  {
    return parent::makeRequest(
      'GET',
      '/v1/forecast/period' . $this->formatQueryParams($payload->getQueryParams())
    );
  }
}
