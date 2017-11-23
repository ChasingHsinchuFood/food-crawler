<?php

/**
 * This is the CrawlBusinessHours class.
 *
 * Crawl the shop business hours(wrong class)
 */

namespace Food\Crawler;

use Symfony\Component\DomCrawler\Crawler;

class CrawlBusinessHours extends CrawlProfile
{
    public function shouldCrawl(string $body)
    {
        return $this->haveHours($body);
    }

    private function haveHours($body)
    {
        $crawler = $this->initialCrawler($body);
        $nodeValues = $crawler->filter('div[class="hours"]')->each(function (Crawler $node, $i) {
            return $node->text();
        });
        var_dump($nodeValues);
    }
}
