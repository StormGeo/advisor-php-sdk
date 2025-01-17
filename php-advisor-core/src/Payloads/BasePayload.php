<?php

namespace StormGeo\AdvisorCore\Payloads;

abstract class BasePayload
{
  /**
   * @param array<string>       $parametersName
   * @param array<string,mixed> $parametersValue
   */
  public function __construct($parametersName, $parametersValue)
  {
    $paramsName = is_array($parametersName) ? $parametersName : [];
    $paramsValue = is_array($parametersValue) ? $parametersValue : [];

    foreach ($paramsName as $param) {
      $this->$param = key_exists($param, $paramsValue) ? $paramsValue[$param] : null;
    }
  }
}
