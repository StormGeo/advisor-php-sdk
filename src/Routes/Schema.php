<?php

namespace StormGeo\AdvisorCore\Routes;

/**
 * @package StormGeo\AdvisorCore
 */
class Schema extends BaseRouter
{
  /**
   * GET /v1/schema/definition
   * 
   * @return  AdvisorResponse
   */
  public function getDefinition()
  {
    return parent::makeRequest('GET', '/v1/schema/definition' . $this->formatQueryParams());
  }

  /**
   * POST /v1/schema/definition
   * 
   * @param   array $payload
   * @return  AdvisorResponse
   */
  public function postDefinition($payload)
  {
    return parent::makeRequest(
      'POST',
      '/v1/schema/definition' . $this->formatQueryParams(),
      $payload,
    );
  }

  /**
   * POST /v1/schema/parameters
   * 
   * @param   array $payload
   * @return  AdvisorResponse
   */
  public function postParameters($payload)
  {
    return parent::makeRequest(
      'POST',
      '/v1/schema/parameters' . $this->formatQueryParams(),
      $payload
    );
  }
}
