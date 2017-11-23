<?php

/**
 * This is the CrawlShopName class.
 *
 * Crawl the shop name from response body strings.
 */

namespace Food\Crawler;

use Symfony\Component\DomCrawler\Crawler;

class CrawlShopName extends CrawlProfile
{
    private $API_ENDPOINT = 'http://www.ipeen.com.tw';

    public function shouldCrawl(string $body)
    {
        return $this->haveShopName($body);
    }

    private function haveShopName($body)
    {
        $crawler = $this->initialCrawler($body);
        $nodeValues = $crawler->filter('title')->each(function (Crawler $node, $i) {
            return $node->text();
        });
        $shopName = explode('@', implode($nodeValues))[0];

        return $shopName;
    }
}
