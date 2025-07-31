<?php

namespace StormGeo\AdvisorCore\Payloads;

class StaticMapPayload extends BasePayload
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
   * @var string
   */
  public $aggregation;

  /**
   * @var string
   */
  public $model;

  /**
   * @var string
   */
  public $lonmin;

  /**
   * @var string
   */
  public $latmin;

  /**
   * @var string
   */
  public $lonmax;

  /**
   * @var string
   */
  public $latmax;

  /**
   * @var int
   */
  public $dpi;

  /**
   * @var string
   */
  public $title;

  /**
   * @var string
   */
  public $titlevariable;

  /**
   * @var int
   */
  public $hours;

  /**
   * @var string
   */
  public $type;

  /**
   * @var string
   */
  public $category;

  /**
   * @var string
   */
  public $variable;

  /**
   * @param array{startDate:string,endDate:string,aggregation:string,model:string,lonmin:string,latmin:string,lonmax:string,latmax:string,dpi:int,title:string,titlevariable:string,hours:int,type:string,category:string,variable:string} $parameters
   */
  public function __construct($parameters = [])
  {
    parent::__construct(
      ['startDate', 'endDate', 'aggregation', 'model', 'lonmin', 'latmin', 'lonmax', 'latmax', 'dpi', 'title', 'titlevariable', 'hours', 'type', 'category', 'variable'],
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
      'aggregation' => $this->aggregation,
      'model' => $this->model,
      'lonmin' => $this->lonmin,
      'latmin' => $this->latmin,
      'lonmax' => $this->lonmax,
      'latmax' => $this->latmax,
      'dpi' => $this->dpi,
      'title' => $this->title,
      'titlevariable' => $this->titlevariable,
      'hours' => $this->hours
    ];
  }
}
