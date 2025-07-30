<?php

namespace StormGeo\AdvisorCore\Payloads;

class StorageDownloadPayload extends BasePayload
{
  /**
   * @var string
   */
	public $fileName;

  /**
   * @var string
   */
  public $accessKey;

  /**
   * @param array{fileName:string,accessKey:string} $parameters
   */
  public function __construct($parameters = [])
  {
    parent::__construct(
      ['fileName', 'accessKey'],
      $parameters
    );
  }

  /**
   * @var array
   */
  public function getQueryParams()
  {
    return [
      'accessKey' => $this->accessKey
    ];
  }
}
