<?php

set_time_limit(0);

require 'vendor/autoload.php';

use Food\Crawler\FoodResource;
use Food\Crawler\CrawlRequest;
use Food\Crawler\CrawlFoodLink;
use Food\Crawler\CrawlBusinessHours;
use Food\Crawler\CrawlAddress;
use Food\Crawler\CrawlRate;
use Food\Crawler\CrawlShopName;
use Food\Crawler\CrawlShopStatus;
use Food\Crawler\CrawlPhoneNumber;
use Food\Crawler\CrawlMapImage;

// get the started page number from arg2
$page = isset($argv[1]) ? $argv[1] : 1;

// seed the random number
srand(5);

// initialize the CSV file
$filePath = './db.shop.csv';
file_exists($filePath) ? null : file_put_contents($filePath, 'address,phone_number,rate,shop_name,static_map_image'.PHP_EOL);

$foodResource = new FoodResource();

$endPage = 384;
$timeout = 30;

for(;$page<=$endPage;$page++) {
    $resource = $foodResource::getSource(0);

    $place = urlencode('新竹');
    $resource = str_replace(['{page}', '{place}'], [$page, $place], $resource);

    $request = new CrawlRequest($resource);

    echo 'crawl '.$resource.PHP_EOL;

    $body = $request->_request($timeout);

    $foodLink = new CrawlFoodLink();
    $link = $foodLink->shouldCrawl($body);

    sleep(rand(10, 20));

    foreach($link as $val) {
        $valArray = explode('-', $val);
        $val = $valArray[0];

        if($val == 'not') {
            continue;
        }

        $request->setResource($val);

        echo 'crawl '.$val.PHP_EOL;

        $body = $request->_request($timeout);

        $shopStatus = new CrawlShopStatus();
        $status = $shopStatus->shouldCrawl($body);

        // if shop status is not the empty string, the shop has been closed.
        if($status != '') {
            continue;
        }

        $foodAddress = new CrawlAddress();
        //$foodBusinessHours = new CrawlBusinessHours();
        $foodPhoneNumber = new CrawlPhoneNumber();
        $foodRate = new CrawlRate();
        $foodShopName = new CrawlShopName();
        $foodImage = new CrawlMapImage();

        $address = $foodAddress->shouldCrawl($body);
        //$businessHours = $foodBusinessHours->shouldCrawl($body);
        $phoneNumber = $foodPhoneNumber->shouldCrawl($body);
        $rate = $foodRate->shouldCrawl($body);
        $shopName = $foodShopName->shouldCrawl($body);
        $image = $foodImage->shouldCrawl($body);

        $foodInfoStr = implode([$address, $phoneNumber, $rate, $shopName, $image], ',');
        file_put_contents($filePath, $foodInfoStr.PHP_EOL, FILE_APPEND);

        sleep(rand(10, 20));
    }
}
