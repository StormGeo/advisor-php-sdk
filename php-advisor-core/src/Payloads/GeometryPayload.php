<?php

namespace StormGeo\AdvisorCore\Payloads;

class GeometryPayload extends BasePayload
{
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
   * @var string
   */
  public $geometry;

  /**
   * @param array{startDate:string,endDate:string,radius:int,geometry:string} $parameters
   */
  public function __construct($parameters = [])
  {
    parent::__construct(
      ['startDate', 'endDate', 'radius', 'geometry'],
      $parameters
    );
  }

  /**
   * @var array
   */
  public function getQueryParams()
  {
    return [
      'startDate' => $this->startDate,
      'endDate' => $this->endDate,
      'radius' => $this->radius
    ];
  }

  /**
   * @var array
   */
  public function getBody()
  {
    return [
      'geometry' => $this->geometry
    ];
  }
}
