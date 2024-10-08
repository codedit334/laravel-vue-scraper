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

    public function scrape()
    {
        // $crawler = $this->client->request('GET', $url);

        // // Scrape the first two articles
        // $articles = $crawler->filter('div.article > div.article-info')->slice(0, 2)->each(function ($node) {
        //     // Scrape title
        //     $title = $node->filter('a.article-title')->text();
        
        //     // Scrape body
        //     $body = $node->filter('a.article-body')->text();
        
        //     return [
        //         'title' => $title,
        //         'body' => $body,
        //     ];
        // });
        
        // List of URLs to scrape
        $urls = [
            [
                'url' => 'https://lematin.ma/sports',
                'urlData' => [
                    'CSSSelector' => 'div.article',
                    'title' => 'a.article-title',
                    'body' => 'a.article-body',
                    'a' => 'a',
                    'img' => 'img',
                ]
            ]
        ];

        // Scrape data
$articles = [];
foreach ($urls as $urlInfo) {
    // $crawler = $this->client->request('GET', $url);

    $crawler = $this->client->request('GET', $urlInfo['url']);

    // Scrape the articles
    $crawler->filter($urlInfo['urlData']['CSSSelector'])->each(function ($node, $index) use (&$articles, $urlInfo) {
        if ($index < 9) { // Only scrape the first two articles

            // Initialize article data
            $article = [];

            // Check for title
            $titleNode = $node->filter($urlInfo['urlData']['title']);
            if ($titleNode->count() > 0) {
                $article['title'] = $titleNode->text();
            } else {
                $article['title'] = 'Title not available';
            }

            // Check for body
            $bodyNode = $node->filter($urlInfo['urlData']['body']);
            if ($bodyNode->count() > 0) {
                $article['body'] = $bodyNode->text();
            } else {
                $article['body'] = 'Body not available';
            }

              // Check for link
              $linkNode = $node->filter($urlInfo['urlData']['a']); // Adjust the selector if you have a specific anchor tag to target
              if ($linkNode->count() > 0) {
                  $article['link'] = $linkNode->attr('href'); // Get the href attribute
              } else {
                  $article['link'] = 'Link not available';
              }

            // Check for image src
            $imageNode = $node->filter($urlInfo['urlData']['img']);
            if ($imageNode->count() > 0) {
                // $article['image'] = $imageNode->attr('src');
                $onerrorAttr = $imageNode->attr('onerror');
        
            // Use regex to extract the fallback src from the onerror attribute
            if (preg_match("/this\.src='(.*?)'/", $onerrorAttr, $matches)) {
                $article['image'] = $matches[1]; // This will give you the fallback URL
            }
            } else {
                $article['image'] = 'Image not available';

            }

            

            // Add article to the list
            $articles[] = $article;
        }
    });
}

        // Optionally, return or process the scraped data
        return $articles;
    }
}