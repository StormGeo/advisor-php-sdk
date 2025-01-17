<?php

namespace StormGeo\AdvisorCore;

use StormGeo\AdvisorCore\Routes\Chart;
use StormGeo\AdvisorCore\Routes\Climatology;
use StormGeo\AdvisorCore\Routes\CurrentWeather;
use StormGeo\AdvisorCore\Routes\Forecast;
use StormGeo\AdvisorCore\Routes\Header;
use StormGeo\AdvisorCore\Routes\Monitoring;
use StormGeo\AdvisorCore\Routes\Observed;
use StormGeo\AdvisorCore\Routes\Plan;
use StormGeo\AdvisorCore\Routes\Schema;
use StormGeo\AdvisorCore\Routes\Tms;

/**
 * @package StormGeo\AdvisorCore
 */
class AdvisorCore
{
  /**
   * @var Chart
   */
  public $chart;

  /**
   * @var Climatology
   */
  public $climatology;

  /**
   * @var CurrentWeather
   */
  public $currentWeather;

  /**
   * @var Forecast
   */
  public $forecast;

  /**
   * @var Monitoring
   */
  public $monitoring;

  /**
   * @var Observed
   */
  public $observed;

  /**
   * @var Plan
   */
  public $plan;

  /**
   * @var Schema
   */
  public $schema;

  /**
   * @var Tms
   */
  public $tms;

  /**
   * @var Header
   */
  private $headers;

  /**
   * @param   string  $token      API Token
   * @param   int     $attempts   Number of attempts if an error occurs
   * @param   int     $delay      Delay between attempts
   */
  public function __construct($token, $attempts = 5, $delay = 5)
  {
    $this->headers = new Header();
    $this->headers->set('Accept', 'application/json');
    $this->headers->set('Content-Type', 'application/json');

    $this->chart = new Chart($token, $attempts, $delay, $this->headers);
    $this->climatology = new Climatology($token, $attempts, $delay, $this->headers);
    $this->currentWeather = new CurrentWeather($token, $attempts, $delay, $this->headers);
    $this->forecast = new Forecast($token, $attempts, $delay, $this->headers);
    $this->monitoring = new Monitoring($token, $attempts, $delay, $this->headers);
    $this->observed = new Observed($token, $attempts, $delay, $this->headers);
    $this->plan = new Plan($token, $attempts, $delay, $this->headers);
    $this->schema = new Schema($token, $attempts, $delay, $this->headers);
    $this->tms = new Tms($token, $attempts, $delay, $this->headers);
  }

  /**
   * @param string $value
   */
  public function setHeaderAccept($value) {
    $this->headers->set('Accept', $value);
  }

  /**
   * @param string $value
   */
  public function setHeaderAcceptLanguage($value) {
    $this->headers->set('Accept-Language', $value);
  }
}
