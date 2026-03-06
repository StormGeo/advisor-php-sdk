<?php

namespace StormGeo\AdvisorCore\Routes;

use StormGeo\AdvisorCore\Payloads\StationsLastDataPayload;

/**
 * @package StormGeo\AdvisorCore
 */
class Stations extends BaseRouter
{
  /**
   * POST /v1/stations/last-data
   *
   * @param   StationsLastDataPayload $payload
   * @return  AdvisorResponse
   */
  public function getLastData($payload)
  {
    return parent::makeRequest(
      'POST',
      '/v1/stations/last-data',
      $payload->getBody()
    );
  }
}
