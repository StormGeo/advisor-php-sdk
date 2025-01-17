<?php

namespace StormGeo\AdvisorCore\Payloads;

class ClimatologyPayload extends BasePayload
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
   * @param array{localeId:int,latitude:string,longitude:string,stationId:string,variables:array<string>} $parameters
   */
  public function __construct($parameters = [])
  {
    parent::__construct(
      ['localeId', 'latitude', 'longitude', 'stationId', 'variables'],
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
