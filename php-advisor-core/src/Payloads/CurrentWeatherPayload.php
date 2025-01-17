<?php

namespace StormGeo\AdvisorCore\Payloads;

class CurrentWeatherPayload extends BasePayload
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
   * @var array<string>
   */
	public $variables;

  /**
   * @var int
   */
	public $timezone;

  /**
   * @param array{localeId:int,latitude:string,longitude:string,stationId:string,variables:array<string>,timezone:int} $parameters
   */
  public function __construct($parameters = [])
  {
    parent::__construct(
      ['localeId', 'latitude', 'longitude', 'stationId', 'variables', 'timezone'],
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
