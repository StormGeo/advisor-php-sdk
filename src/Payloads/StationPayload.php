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
   * @var int
   */
	public $timezone;

  /**
   * @param array{stationId:string,startDate:string,endDate:string,variables:array<string>,layer:string,timezone:int} $parameters
   */
  public function __construct($parameters = [])
  {
    parent::__construct(
      ['stationId', 'startDate', 'endDate', 'variables', 'layer', 'timezone'],
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
