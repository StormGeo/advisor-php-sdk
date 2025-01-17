<?php

namespace StormGeo\AdvisorCore\Routes;

use StormGeo\AdvisorCore\Payloads\ClimatologyPayload;

/**
 * @package StormGeo\AdvisorCore
 */
class Climatology extends BaseRouter
{
  /**
   * GET /v1/climatology/daily
   * 
   * @param   ClimatologyPayload $payload
   * @return  AdvisorResponse
   */
  public function getDaily($payload)
  {
    return parent::makeRequest(
      'GET',
      '/v1/climatology/daily' . $this->formatQueryParams($payload->getQueryParams())
    );
  }

  /**
   * GET /v1/climatology/monthly
   * 
   * @param   ClimatologyPayload $payload
   * @return  AdvisorResponse
   */
  public function getMonthly($payload)
  {
    return parent::makeRequest(
      'GET',
      '/v1/climatology/monthly' . $this->formatQueryParams($payload->getQueryParams())
    );
  }
}
