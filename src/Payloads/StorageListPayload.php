<?php

namespace StormGeo\AdvisorCore\Payloads;

class StorageListPayload extends BasePayload
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
  public $startDate;

  /**
   * @var string
   */
  public $endDate;

  /**
   * @var string
   */
	public $fileName;

  /**
   * @var string
   */
  public $fileExtension;

  /**
   * @var string[]
   */
  public $fileTypes;

  /**
   * @param array{page:int,pageSize:int,startDate:string,endDate:string,fileName:string,fileExtension:string,fileTypes:string[]} $parameters
   */
  public function __construct($parameters = [])
  {
    parent::__construct(
      ['page', 'pageSize', 'startDate', 'endDate', 'fileName', 'fileExtension', 'fileTypes'],
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
