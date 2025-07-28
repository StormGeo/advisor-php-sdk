<?php

namespace StormGeo\AdvisorCore\Payloads;

class RequestDetailsPayload extends BasePayload
{
  /**
   * @var int
   */
	public $page;

  /**
   * @var int
   */
	public $pageSize;

  /**
   * @var string
   */
	public $path;

  /**
   * @var string
   */
  public $status;

  /**
   * @var string
   */
	public $startDate;

  /**
   * @var string
   */
  public $endDate;

  /**
   * @param array{page:int,pageSize:int,path:string,status:string,startDate:string,endDate:string} $parameters
   */
  public function __construct($parameters = [])
  {
    parent::__construct(
      ['page', 'pageSize', 'path', 'status', 'startDate', 'endDate'],
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
