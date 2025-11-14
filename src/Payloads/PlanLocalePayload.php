<?php

namespace StormGeo\AdvisorCore\Payloads;

class PlanLocalePayload extends BasePayload
{
  /**
   * @var int
   */
  public $localeId;

  /**
   * @var string
   */
  public $stationId;

  /**
   * @var string
   */
  public $latitude;

  /**
   * @var string
   */
  public $longitude;

  /**
   * @param array{localeId:int,stationId:string,latitude:string,longitude:string} $parameters
   */
  public function __construct($parameters = [])
  {
    parent::__construct(
      ['localeId', 'stationId', 'latitude', 'longitude'],
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
