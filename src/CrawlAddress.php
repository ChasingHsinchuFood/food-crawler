<?php

/**
 * This is the CrawlAddress class.
 *
 * Crawl the shop address from the response body strings.
 */

namespace Food\Crawler;

use Symfony\Component\DomCrawler\Crawler;

class CrawlAddress extends CrawlProfile
{
    public function shouldCrawl(string $body)
    {
        return $this->haveAddress($body);
    }

    private function haveAddress($body)
    {
        $crawler = $this->initialCrawler($body);
        $nodeValues = $crawler->filter('meta[property="ipeen_app:address"]')->each(function (Crawler $node, $i) {
            return $node->attr('content');
        });

        return implode($nodeValues);
    }
}
