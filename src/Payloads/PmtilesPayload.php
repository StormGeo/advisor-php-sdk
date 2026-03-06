<?php

namespace StormGeo\AdvisorCore\Payloads;

class PmtilesPayload extends BasePayload
{
  /**
   * @var string
   */
  public $mode;

  /**
   * @var string
   */
  public $model;

  /**
   * @var string
   */
  public $aggregation;

  /**
   * @var string
   */
  public $variable;

  /**
   * @var string
   */
  public $istep;

  /**
   * @var string
   */
  public $fstep;

  /**
   * @var int
   */
  public $maxZoom;

  /**
   * @var int
   */
  public $timezone;

  /**
   * @param array{mode:string,model:string,aggregation:string,variable:string,istep:string,fstep:string,maxZoom:int,timezone:int} $parameters
   */
  public function __construct($parameters = [])
  {
    parent::__construct(
      ['mode', 'model', 'aggregation', 'variable', 'istep', 'fstep', 'maxZoom', 'timezone'],
      $parameters
    );
  }

  /**
   * @return array
   */
  public function getQueryParams()
  {
    return [
      'istep' => $this->istep,
      'fstep' => $this->fstep,
      'maxZoom' => $this->maxZoom,
      'timezone' => $this->timezone,
    ];
  }
}
