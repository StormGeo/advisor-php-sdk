<?php

namespace StormGeo\AdvisorCore\Payloads;

class RadiusPayload extends BasePayload
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
	public $startDate;

  /**
   * @var string
   */
  public $endDate;

  /**
   * @var int
   */
  public $radius;

  /**
   * @param array{localeId:int,latitude:string,longitude:string,startDate:string,endDate:string,radius:int} $parameters
   */
  public function __construct($parameters = [])
  {
    parent::__construct(
      ['localeId', 'latitude', 'longitude', 'startDate', 'endDate', 'radius'],
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
