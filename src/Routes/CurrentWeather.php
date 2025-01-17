<?php

namespace StormGeo\AdvisorCore\Routes;

use StormGeo\AdvisorCore\Payloads\CurrentWeatherPayload;

/**
 * @package StormGeo\AdvisorCore
 */
class CurrentWeather extends BaseRouter
{
  /**
   * GET /v1/current-weather
   * 
   * @param   CurrentWeatherPayload $payload
   * @return  AdvisorResponse
   */
  public function get($payload)
  {
    return parent::makeRequest(
      'GET',
      '/v1/current-weather' . $this->formatQueryParams($payload->getQueryParams())
    );
  }
}
