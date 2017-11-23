<?php

namespace Food\Crawler;

use GuzzleHttp\Client;

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
        $response = $client->get($this->resource);

        return $response->getBody()->getContents();
    }
}
