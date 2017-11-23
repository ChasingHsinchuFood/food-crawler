<?php

/**
 * This is the CrawlPhoneNumber class.
 *
 * Crawl the phone number from response body strings.
 */

namespace Food\Crawler;

use Symfony\Component\DomCrawler\Crawler;

class CrawlPhoneNumber extends CrawlProfile
{
    public function shouldCrawl(string $body)
    {
        return $this->havePhoneNumber($body);
    }

    private function havePhoneNumber($body)
    {
        $crawler = $this->initialCrawler($body);
        $nodeValues = $crawler->filter('meta[itemprop="telephone"]')->each(function (Crawler $node, $i) {
            return $node->attr('content');
        });

        return implode($nodeValues);
    }
}
