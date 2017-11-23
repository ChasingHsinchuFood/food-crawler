<?php

/**
 * This is the FoodResource class.
 *
 * The food resources from response body strings.
 */

namespace Food\Crawler;

class FoodResource
{
    private static $resource = [
        'http://www.ipeen.com.tw/search/all/000/1-100-0-0/?p={page}&adkw={place}',
        'https://api.yelp.com',
    ];

    public static function getSource($index)
    {
        return empty(FoodResource::$resource[$index]) ? false : FoodResource::$resource[$index];
    }

    public static function getSources()
    {
        return $this->resource;
    }
}
