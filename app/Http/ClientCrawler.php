<?php

namespace App\Http;

use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ClientCrawler
 * @package App
 */
class ClientCrawler
{
    /**
     * Guzzle client
     *
     * @var GuzzleClient
     */
    public $client;

    /**
     * Form params
     *
     * @var array
     */
    private $params = [];

    /**
     * Header of request
     *
     * @var array
     */
    private $headers = [];

    /**
     * Construct a client crawler
     *
     * ClientCrawler constructor.
     * @param $url
     */
    public function __construct($url)
    {
        $this->client = new GuzzleClient(
            [
                'base_uri' => $url
            ]
        );

        return $this;
    }
    /**
     * Set headers
     *
     * @param  $headers
     * @return ClientCrawler
     */
    public function setHeaders($headers): ClientCrawler
    {
        $this->headers = array_merge($headers,
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        );
        return $this;
    }
    /**
     * Set params
     *
     * @param $params
     * @return $this
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }
    /**
     * Make a request
     *
     * @param $uri
     * @param $method
     * @return mixed|ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request($uri, $method){
        return $this->client->request($method , $uri,
            [
                'headers' =>  $this->headers,
                'form_params'    => $this->params
            ]
        );
    }
}
