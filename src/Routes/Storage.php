<?php

namespace StormGeo\AdvisorCore\Routes;

use StormGeo\AdvisorCore\Payloads\StorageListPayload;
use StormGeo\AdvisorCore\Payloads\StorageDownloadPayload;

/**
 * @package StormGeo\AdvisorCore
 */
class Storage extends BaseRouter
{
  /**
   * GET /v1/storage/list
   * 
   * @param   StorageListPayload $payload
   * @return  AdvisorResponse
   */
  public function listFiles($payload)
  {
    return parent::makeRequest(
      'GET',
      '/v1/storage/list' . $this->formatQueryParams($payload->getQueryParams())
    );
  }

  /**
   * GET /v1/storage/download/{fileName}
   * 
   * @param   StorageDownloadPayload $payload
   * @return  AdvisorResponse
   */
  public function downloadFile($payload)
  {
    return parent::makeRequest(
      'GET_FILE',
      "/v1/storage/download/{$payload->fileName}" . $this->formatQueryParams($payload->getQueryParams())
    );
  }

  /**
   * GET /v1/storage/download/{fileName}
   * 
   * @param   StorageDownloadPayload $payload
   * @return  AdvisorResponse
   */
  public function downloadFileByStream($payload)
  {
    return parent::makeRequest(
      'GET_STREAM',
      "/v1/storage/download/{$payload->fileName}" . $this->formatQueryParams($payload->getQueryParams())
    );
  }
}
