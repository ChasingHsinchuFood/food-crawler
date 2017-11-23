<?php

/**
 * This is the CrawlAddress class.
 *
 * Crawl the shop address image from the response body strings.
 */

namespace Food\Crawler;

use Symfony\Component\DomCrawler\Crawler;

class CrawlMapImage extends CrawlProfile
{
    public function shouldCrawl(string $body)
    {
        return $this->haveMapImage($body);
    }

    private function haveMapImage($body)
    {
        $crawler = $this->initialCrawler($body);
        $nodeValues = $crawler->filter('div#s-staticmap > img')->each(function (Crawler $node, $i) {
            return $node->attr('src');
        });

        return implode($nodeValues);
    }
}
