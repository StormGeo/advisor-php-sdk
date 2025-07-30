<?php

namespace StormGeo\AdvisorCore\Routes;

/**
 * @package StormGeo\AdvisorCore
 */
class AdvisorResponse
{
  /**
   * @var array|string|resource|null
   */
  public $data = null;

  /**
   * @var array|string|null
   */
  public $error = null;

  public function __construct($data)
  {
    if (is_resource($data)) {
      $this->data = $data;
      $this->error = null;
      return;
    }

    if (!is_array($data)) {
      $dataToString = (string) $data;
      $hasError = strpos($dataToString, 'error') !== false;
      $this->data = !$hasError ? $dataToString : null;
      $this->error = $hasError ? $dataToString : null;
    } else {
      $hasError = array_key_exists('error', $data);
      $this->data = !$hasError ? $data : null;
      $this->error = $hasError ? $data['error'] : null;
    }
  }
}
