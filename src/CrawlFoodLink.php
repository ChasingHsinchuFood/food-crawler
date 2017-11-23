<?php

/**
 * This is the CrawlFoodLink class.
 *
 * Crawl the shop food link from response body strings.
 */

namespace Food\Crawler;

use Symfony\Component\DomCrawler\Crawler;

class CrawlFoodLink extends CrawlProfile
{
    private $API_ENDPOINT = 'http://www.ipeen.com.tw';

    public function shouldCrawl(string $body)
    {
        return $this->haveFoodLink($body);
    }

    private function haveFoodLink(string $body)
    {
        $crawler = $this->initialCrawler($body);
        $nodeValues = $crawler->filter('a[class="a37 ga_tracking"]')->each(function (Crawler $node, $i) {
            $shopLink = $this->API_ENDPOINT.$node->attr('href');
            if(stristr($shopLink, 'shop') !== false) {
                return $shopLink;
            }

            return 'not-link';
        });

        return $nodeValues;
    }
}
