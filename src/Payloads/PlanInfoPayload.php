<?php

namespace StormGeo\AdvisorCore\Payloads;

class PlanInfoPayload extends BasePayload
{
  /**
   * @var int
   */
	public $timezone;

  /**
   * @param array{timezone:int} $parameters
   */
  public function __construct($parameters = [])
  {
    parent::__construct(
      ['timezone'],
      $parameters
    );
  }

  /**
   * @var array
   */
  public function getQueryParams()
  {
    return (array) $this;
  }
}
