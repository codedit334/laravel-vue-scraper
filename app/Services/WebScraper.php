<?php

namespace App\Services;

use Goutte\Client;

class WebScraper
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function scrape($url)
    {
        $crawler = $this->client->request('GET', $url);

        // Example: Scrape titles from <h1> tags
        return $crawler->filter('h1')->each(function ($node) {
            return $node->text();
        });
    }
}