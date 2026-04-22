<?php

namespace StormGeo\AdvisorCore\Payloads;

class LightningLitePayload extends BasePayload
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
   * @var int
   */
  public $page;

  /**
   * @var int
   */
  public $pageSize;

  /**
   * @var array
   */
  public $sources;

  /**
   * @param array{startDate:string,endDate:string,radius:int,geometry:string,page:int,pageSize:int,sources:array} $parameters
   */
  public function __construct($parameters = [])
  {
    parent::__construct(
      ['startDate', 'endDate', 'radius', 'geometry', 'page', 'pageSize', 'sources'],
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
      'radius' => $this->radius,
      'page' => $this->page,
      'pageSize' => $this->pageSize,
      'sources' => $this->sources
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
