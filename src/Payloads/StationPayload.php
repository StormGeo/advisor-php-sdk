<?php

namespace StormGeo\AdvisorCore\Payloads;

class StationPayload extends BasePayload
{
  /**
   * @var string
   */
  public $stationId;

  /**
   * @var string
   */
	public $startDate;

  /**
   * @var string
   */
  public $endDate;

  /**
   * @var array<string>
   */
	public $variables;

  /**
   * @var string
   */
	public $layer;

  /**
   * @param array{stationId:string,startDate:string,endDate:string,variables:array<string>,layer:string} $parameters
   */
  public function __construct($parameters = [])
  {
    parent::__construct(
      ['stationId', 'startDate', 'endDate', 'variables', 'layer'],
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
