<?php

namespace StormGeo\AdvisorCore\Routes;

use StormGeo\AdvisorCore\Payloads\WeatherPayload;

/**
 * @package StormGeo\AdvisorCore
 */
class Chart extends BaseRouter
{
  /**
   * GET /v1/forecast/daily/chart
   * 
   * @param   WeatherPayload $payload
   * @return  AdvisorResponse
   */
  public function getForecastDaily($payload)
  {
    return parent::makeRequest(
      'GET_IMAGE',
      '/v1/forecast/daily/chart' . $this->formatQueryParams($payload->getQueryParams())
    );
  }

  /**
   * GET /v1/forecast/hourly/chart
   * 
   * @param   WeatherPayload $payload
   * @return  AdvisorResponse
   */
  public function getForecastHourly($payload)
  {
    return parent::makeRequest(
      'GET_IMAGE',
      '/v1/forecast/hourly/chart' . $this->formatQueryParams($payload->getQueryParams())
    );
  }

  /**
   * GET /v1/observed/daily/chart
   * 
   * @param   WeatherPayload $payload
   * @return  AdvisorResponse
   */
  public function getObservedDaily($payload)
  {
    return parent::makeRequest(
      'GET_IMAGE',
      '/v1/observed/daily/chart' . $this->formatQueryParams($payload->getQueryParams())
    );
  }

  /**
   * GET /v1/observed/hourly/chart
   * 
   * @param   WeatherPayload $payload
   * @return  AdvisorResponse
   */
  public function getObservedHourly($payload)
  {
    return parent::makeRequest(
      'GET_IMAGE',
      '/v1/observed/hourly/chart' . $this->formatQueryParams($payload->getQueryParams())
    );
  }
}
