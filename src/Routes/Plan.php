<?php

namespace StormGeo\AdvisorCore\Routes;

/**
 * @package StormGeo\AdvisorCore
 */
class Plan extends BaseRouter
{
  /**
   * GET /v1/plan/{token}
   * 
   * @return  AdvisorResponse
   */
  public function getInfo()
  {
    return parent::makeRequest('GET', "/v1/plan/{$this->token}");
  }
}
