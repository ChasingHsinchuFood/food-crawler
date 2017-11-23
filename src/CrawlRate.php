<?php

/**
 * This is the CrawlRate class.
 *
 * Crawl the shop rate from response body strings.
 */

namespace Food\Crawler;

use Symfony\Component\DomCrawler\Crawler;

class CrawlRate extends CrawlProfile
{
    public function shouldCrawl(string $body)
    {
        return $this->haveRate($body);
    }

    private function haveRate($body)
    {
        $crawler = $this->initialCrawler($body);
        $nodeValues = $crawler->filter('span[itemprop="ratingValue"]')->each(function (Crawler $node, $i) {
            return (int)$node->text();
        });

        return implode($nodeValues);
    }
}
