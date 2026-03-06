<?php

namespace StormGeo\AdvisorCore\Routes;

use StormGeo\AdvisorCore\Payloads\PmtilesPayload;

/**
 * @package StormGeo\AdvisorCore
 */
class Pmtiles extends BaseRouter
{
  /**
   * GET /v1/pmtiles/{mode}/{model}/{aggregation}/{variable}.pmtiles
   *
   * @param   PmtilesPayload $payload
   * @return  AdvisorResponse
   */
  public function get($payload)
  {
    $route = sprintf(
      '/v1/pmtiles/%s/%s/%s/%s.pmtiles',
      $payload->mode,
      $payload->model,
      $payload->aggregation,
      $payload->variable
    );

    return parent::makeRequest(
      'GET_FILE',
      $route . $this->formatQueryParams($payload->getQueryParams())
    );
  }
}
