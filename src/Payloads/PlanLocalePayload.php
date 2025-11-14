<?php

namespace StormGeo\AdvisorCore\Payloads;

class PlanLocalePayload extends BasePayload
{
  /**
   * @var int
   */
	public $localeId;

  /**
   * @var string|null
   */
  public $stationId;

  /**
   * @var string|null
   */
  public $latitude;

  /**
   * @var string|null
   */
  public $longitude;

  /**
   * @param array{
   *   localeId?:int,
   *   stationId?:string,
   *   latitude?:string,
   *   longitude?:string
   * } $parameters
   */
  public function __construct($parameters = [])
  {
    parent::__construct(['localeId', 'stationId', 'latitude', 'longitude'], $parameters);
  }

  /**
   * @return array
   */
  public function getQueryParams()
  {
    return (array) $this;
  }
}
