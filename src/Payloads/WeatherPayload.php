<?php

namespace StormGeo\AdvisorCore\Payloads;

class WeatherPayload extends BasePayload
{
  /**
   * @var int
   */
	public $localeId;

  /**
   * @var string
   */
	public $latitude;

  /**
   * @var string
   */
	public $longitude;

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
   * @var int
   */
	public $timezone;

  /**
   * @param array{localeId:int,latitude:string,longitude:string,stationId:string,startDate:string,endDate:string,variables:array<string>,timezone:int} $parameters
   */
  public function __construct($parameters = [])
  {
    parent::__construct(
      ['localeId', 'latitude', 'longitude', 'stationId', 'startDate', 'endDate', 'variables', 'timezone'],
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
