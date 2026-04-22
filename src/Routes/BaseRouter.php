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
  protected function makeRequest($method, $route, $body = [], $includeTokenHeader = true)
  {
    if ($method === 'GET' || $method === 'GET_FILE' || $method === 'GET_STREAM') {
      return $this->retryRequest(
        function() use ($method, $route, $includeTokenHeader) {
          if ($method === 'GET_STREAM') {
            return $this->makeGetRequestStream($this::BASE_URL . $route, $includeTokenHeader);
          }
          return $this->makeGetRequest($this::BASE_URL . $route, $method === 'GET_FILE', $includeTokenHeader);
        },
        $this->retries,
        $this->delay
      );
    }

    if ($method === 'POST') {
      return $this->retryRequest(
        function() use ($route, $body, $includeTokenHeader) {
          return $this->makePostRequest($this::BASE_URL . $route, $body, $includeTokenHeader);
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
  protected function makeGetRequest($url, $binaryReturn = false, $includeTokenHeader = true)
  {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $this->buildRequestHeaders($includeTokenHeader));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);

    $response = curl_exec($ch);
    $responseInfo = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($response != false) {
      $isBinary = $binaryReturn && $responseInfo == 200;
      $transformToJson = $this->headers->get('Accept') === 'application/json' && !$isBinary;

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
   * @return  array       array{statusCode:int|null,data:resource|string|array|null}
   */
  protected function makeGetRequestStream($url, $includeTokenHeader = true)
  {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $this->buildRequestHeaders($includeTokenHeader));
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);

    $stream = fopen('php://temp', 'w+');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
    curl_setopt($ch, CURLOPT_FILE, $stream);

    curl_exec($ch);
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    rewind($stream);

    if ($statusCode >= 400) {
      $contents = stream_get_contents($stream);
      fclose($stream);
      $transformToJson = $this->headers->get('Accept') === 'application/json';

      return [
        'statusCode' => $statusCode,
        'data' => $transformToJson ? json_decode($contents, true) : $contents,
      ];
    }

    return [
      'statusCode' => $statusCode,
      'data' => $stream,
    ];
  }

  /**
   * @param   string      $url
   * @param   array       $body
   * @return  array
   */
  protected function makePostRequest($url, $body, $includeTokenHeader = true)
  {
    $this->headers->set('Content-Type', 'application/json');

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $this->buildRequestHeaders($includeTokenHeader));

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

      if (!is_null($status) && $status < 500) {
        return new AdvisorResponse($data);
      }

      if ($retryNumber > 0) {
        sleep($delay);
      }
    }

    return new AdvisorResponse($data);
  }

  /**
   * @param   array|null   $queryParams
   * @return  string
   */
  protected function formatQueryParams($queryParams = null)
  {
    if (empty($queryParams)) {
      return '';
    }

    $formattedParams = http_build_query($queryParams);
    if (strlen($formattedParams) === 0) {
      return '';
    }

    $formattedParams = preg_replace('/%5B[0-9]+%5D/simU', '[]', $formattedParams);

    return "?{$formattedParams}";
  }

  /**
   * @param   bool    $includeTokenHeader
   * @return  array
   */
  protected function buildRequestHeaders($includeTokenHeader = true)
  {
    $formattedHeaders = $this->headers->getFormattedHeaders();

    if ($includeTokenHeader) {
      $formattedHeaders[] = "x-advisor-token: {$this->token}";
    }

    return $formattedHeaders;
  }
}
