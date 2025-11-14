<?php

namespace StormGeo\AdvisorCore\Routes;

use StormGeo\AdvisorCore\Payloads\PlanInfoPayload;
use StormGeo\AdvisorCore\Payloads\PlanLocalePayload;
use StormGeo\AdvisorCore\Payloads\RequestDetailsPayload;

/**
 * @package StormGeo\AdvisorCore
 */
class Plan extends BaseRouter
{
  /**
   * GET /v1/plan/{token}
   * 
   * @param   PlanInfoPayload $payload
   * @return  AdvisorResponse
   */
  public function getInfo($payload = null)
  {
    $queryParams = $payload ? $this->formatQueryParams($payload->getQueryParams()) : '';

    return parent::makeRequest(
      'GET',
      "/v1/plan/{$this->token}" . $queryParams
    );
  }

  /**
   * GET /v1/plan/request-details
   * 
   * @param   RequestDetailsPayload $payload
   * @return  AdvisorResponse
   */
  public function getRequestDetails($payload)
  {
    return parent::makeRequest(
      'GET',
      '/v1/plan/request-details' . $this->formatQueryParams($payload->getQueryParams())
    );
  }

  /**
   * GET /v1/plan/locale
   *
   * @param   PlanLocalePayload $payload
   * @return  AdvisorResponse
   */
  public function getLocale($payload)
  {
    return parent::makeRequest(
      'GET',
      '/v1/plan/locale' . $this->formatQueryParams($payload->getQueryParams())
    );
  }
}
