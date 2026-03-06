<?php

namespace StormGeo\AdvisorCore\Payloads;

class StationsLastDataPayload extends BasePayload
{
  /**
   * @var array<string>|null
   */
  public $stationIds;

  /**
   * @var array<string>|null
   */
  public $variables;

  /**
   * @param array{stationIds?:array<string>,variables?:array<string>} $parameters
   */
  public function __construct($parameters = [])
  {
    parent::__construct(
      ['stationIds', 'variables'],
      $parameters
    );
  }

  /**
   * @var array
   */
  public function getBody()
  {
    return array_filter([
      'stationIds' => $this->stationIds,
      'variables' => $this->variables
    ], function ($value) {
      return !is_null($value);
    });
  }
}
