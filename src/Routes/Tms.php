<?php

namespace StormGeo\AdvisorCore\Routes;

use StormGeo\AdvisorCore\Payloads\TmsPayload;

/**
 * @package StormGeo\AdvisorCore
 */
class Tms extends BaseRouter
{
  /**
   * GET /v1/tms/{server}/{mode}/{variable}/{aggregation}/{x}/{y}/{z}.png
   * 
   * @param   TmsPayload $payload
   * @return  AdvisorResponse
   */
  public function get($payload)
  {
    $route = sprintf(
      '/v1/tms/%s/%s/%s/%s/%d/%d/%d.png',
      $payload->server,
			$payload->mode,
			$payload->variable,
			$payload->aggregation,
			$payload->x,
			$payload->y,
			$payload->z
    );

    return parent::makeRequest('GET_IMAGE', $route . $this->formatQueryParams($payload->getQueryParams()));
  }
}
