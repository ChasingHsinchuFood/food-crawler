<?php

/**
 * This is the CrawlRequest class.
 *
 * set the url source and send the HTTP request to get response body strings.
 */

namespace Food\Crawler;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;

class CrawlRequest
{
    private $resource;

    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    public function setResource($resource)
    {
        $this->resource = $resource;
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function _request($timeout)
    {
        $client = new Client(['timeout' => $timeout]);
        try {
            $response = $client->get($this->resource);
        } catch(ConnectException $e) {
            if(stristr($e->getMessage(), 'cURL error 28') !== false) {
                srand(5);
                sleep(rand(1, 10));
                $response = $client->get($this->resource);
            }
        }

        return $response->getBody()->getContents();
    }
}
