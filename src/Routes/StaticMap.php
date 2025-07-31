<?php

namespace StormGeo\AdvisorCore\Routes;

use StormGeo\AdvisorCore\Payloads\StaticMapPayload;

/**
 * @package StormGeo\AdvisorCore
 */
class StaticMap extends BaseRouter
{
  /**
   * GET /v1/map/{type}/{category}/{variable}
   *
   * @param   StaticMapPayload $payload
   * @return  AdvisorResponse
   */
  public function get_static_map($payload)
  {
    $route = sprintf(
      '/v1/map/%s/%s/%s',
      $payload->type,
      $payload->category,
      $payload->variable
    );

    return parent::makeRequest(
      'GET_FILE',
      $route . $this->formatQueryParams($payload->getQueryParams())
    );
  }
}
