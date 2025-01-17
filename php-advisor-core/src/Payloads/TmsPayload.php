<?php

namespace StormGeo\AdvisorCore\Payloads;

class TmsPayload extends BasePayload
{
  /**
   * @var string
   */
  public $istep;

  /**
   * @var string
   */
	public $fstep;

  /**
   * @var string
   */
	public $server;

  /**
   * @var string
   */
	public $mode;

  /**
   * @var string
   */
	public $variable;

  /**
   * @var string
   */
	public $aggregation;

  /**
   * @var int
   */
	public $x;

  /**
   * @var int
   */
	public $y;

  /**
   * @var int
   */
	public $z;

  /**
   * @param array{istep:string,fstep:string,server:string,mode:string,variable:string,aggregation:string,x:int,y:int,z:int} $parameters
   */
  public function __construct($parameters = [])
  {
    parent::__construct(
      ['istep', 'fstep', 'server', 'mode', 'variable', 'aggregation', 'x', 'y', 'z'],
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
    ];
  }
}
