<?php

/**
 * This is the CrawlShopStatus class.
 *
 * Crawl the shop status from response body strings.
 */

namespace Food\Crawler;

use Symfony\Component\DomCrawler\Crawler;

class CrawlShopStatus extends CrawlProfile
{
    public function shouldCrawl(string $body)
    {
        return $this->haveShopStatus($body);
    }

    private function haveShopStatus($body)
    {
        $crawler = $this->initialCrawler($body);
        $nodeValues = $crawler->filter('span[class="mark-text gray"]')->each(function (Crawler $node, $i) {
            return $node->text();
        });

        return implode($nodeValues);
    }
}
