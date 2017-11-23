<?php

/**
 * This is the CrawlProfile interface.
 *
 * The interface defines the resuable methods for the Crawl* series classes.
 */

namespace Food\Crawler;

use Symfony\Component\DomCrawler\Crawler;

abstract class CrawlProfile
{
    private function shouldCrawl(string $body)
    {
    }

    public function initialCrawler($body)
    {
        return new Crawler($body);
    }
}
