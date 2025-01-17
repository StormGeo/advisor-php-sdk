<?php

namespace StormGeo\AdvisorCore\Routes;

/**
 * @package StormGeo\AdvisorCore
 */
abstract class BaseRouter
{
  const BASE_URL = 'https://advisor-core.climatempo.io/api';

  /**
   * @var string
   */
  protected $token;

  /**
   * @var int
   */
  protected $retries;

  /**
   * @var int
   */
  protected $delay;

  /**
   * @var Header
   */
  protected $headers;

  /**
   * @param   string  $token
   * @param   int     $retries
   * @param   int     $delay
   * @param   Header  $headers
   */
  public function __construct($token, $retries, $delay, $headers)
  {
    $this->token = $token;
    $this->retries = $retries;
    $this->delay = $delay;
    $this->headers = $headers;
  }

  /**
   * @param   string            $method
   * @param   string            $route
   * @param   array             $body
   * @return  AdvisorResponse
   */
  protected function makeRequest($method, $route, $body = [])
  {
    if ($method === 'GET' || $method === 'GET_IMAGE') {
      return $this->retryRequest(
        function() use ($method, $route) {
          return $this->makeGetRequest($this::BASE_URL . $route, $method === 'GET_IMAGE');
        },
        $this->retries,
        $this->delay
      );
    }

    if ($method === 'POST') {
      return $this->retryRequest(
        function() use ($route, $body) {
          return $this->makePostRequest($this::BASE_URL . $route, $body);
        },
        $this->retries,
        $this->delay
      );
    }

    return null;
  }

  /**
   * @param   string      $url
   * @param   bool        $binaryReturn
   * @return  array
   */
  protected function makeGetRequest($url, $binaryReturn = false)
  {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers->getFormattedHeaders());
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPGET, true);

    $response = curl_exec($ch);
    $responseInfo = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($response != false) {
      $transformToJson = $this->headers->get('Accept') === 'application/json' && !$binaryReturn;

      return [
        'statusCode' => $responseInfo,
        'data' => $transformToJson ? json_decode($response, true) : $response
      ];
    }

    return [
      'statusCode' => null,
      'data' => null
    ];
  }

  /**
   * @param   string      $url
   * @param   array       $body
   * @return  array
   */
  protected function makePostRequest($url, $body)
  {
    $this->headers->set('Content-Type', 'application/json');

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers->getFormattedHeaders());

    $response = curl_exec($ch);
    $responseInfo = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($response != false) {
      $transformToJson = $this->headers->get('Accept') === 'application/json';

      return [
        'statusCode' => $responseInfo,
        'data' => $transformToJson ? json_decode($response, true) : $response
      ];
    }

    return [
      'statusCode' => null,
      'data' => null
    ];
  }

  /**
   * @param   callable():(array|null)  $request
   * @param   int                       $retries
   * @param   int                       $delay
   * @return  AdvisorResponse
   */
  protected function retryRequest($request, $retries, $delay)
  {
    $data = new AdvisorResponse(null);

    for ($retryNumber = $retries; $retryNumber >= 0; $retryNumber--) {
      $response = $request();
      $status = $response['statusCode'];
      $data = $response['data'];

      if (!is_null($status) && $status < 500 && $status != 429) {
        return new AdvisorResponse($data);
      }

      if ($retryNumber > 0) {
        sleep($delay);
      }
    }

    return $data;
  }

  /**
   * @param   array|null   $queryParams
   * @return  string
   */
  protected function formatQueryParams($queryParams = null)
  {
    $params = "?token={$this->token}";
    $formattedParams = is_null($queryParams) ? '' : http_build_query($queryParams);
    if (strlen($formattedParams) > 0) {
      $params .= "&{$formattedParams}";
      $params = preg_replace('/%5B[0-9]+%5D/simU', '[]', $params);
    }

    return $params;
  }
}
