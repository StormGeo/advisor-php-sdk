<?php

namespace StormGeo\AdvisorCore\Routes;

/**
 * @package StormGeo\AdvisorCore
 */
class Header
{
  /**
   * @var array
   */
  private $headers = [];

  /**
   * @param   string      $header
   * @return  string|null
   */
  public function get($header)
  {
    return $this->headers[$header] ?? null;
  }

  /**
   * @param string $header
   * @param string $value
   */
  public function set($header, $value)
  {
    $this->headers[$header] = $value;
  }

  /**
   * @return array
   */
  public function getFormattedHeaders()
  {
    $formattedHeaders = [];
    foreach ($this->headers as $header => $value) {
      if ($value != '') {
        $formattedHeaders[] = "{$header}: {$value}";
      }
    }

    return $formattedHeaders;
  }
}
