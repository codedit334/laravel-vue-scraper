<?php

namespace App\Services;

use Goutte\Client;
use App\Services\TextTagger;

class WebScraper
{
    protected $client;

    public $urls = [
        [
            'url' => 'https://lematin.ma/sports',
            'urlData' => [
                'CSSSelector' => 'div.article',
                'title' => 'a.article-title',
                'body' => 'a.article-body',
                'a' => 'a',
                'img' => 'div.article-image img',
                'attr' => 'onerror',
            ]
            ],
            [
                'url' => 'https://www.clubs.ma/evenements/',
                'urlData' => [
                    'CSSSelector' => 'div.card-item',
                    'title' => '.card-body a',
                    'body' => '.card-text',
                    'a' => 'div > a',
                    'img' => 'img',
                    'attr' => 'data-src',
                ]
                ],
                [
                    'url' => 'https://sport.le360.ma',
                    'urlData' => [
                        'CSSSelector' => '.article-list-item',
                        'title' => '.headline-text',
                        'body' => '.description-text',
                        'a' => 'div > a',
                        'img' => 'img',
                        'attr' => 'src',
                    ]
                    ],
    ];

    public $coaches = [
        [
            'name' => 'Mehdi',
            'work' => 'Fitness Coach',
            'image' => 'https://images.pexels.com/photos/2379004/pexels-photo-2379004.jpeg?auto=compress&cs=tinysrgb&w=600',
            'tags'  => ['Fitness', 'Gym'],
        ],
        [
            'name' => 'Simo',
            'work' => 'Football',
            'image' => 'https://images.pexels.com/photos/1681010/pexels-photo-1681010.jpeg?auto=compress&cs=tinysrgb&w=600',
            'tags' => ['Football,', 'Stade', 'raja', 'wydad', 'WAC', 'widad', 'Real', 'Sociedad', 'soccer', 'fifa', 'messi', 'ronaldo', "coupe", 'hakimi', 'nff', 'Regragui'],
        ],
        [
            'name' => 'Ghizlane',
            'work' => 'Cyclism',
            'image' => 'https://images.pexels.com/photos/415829/pexels-photo-415829.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
            'tags' => ['Bike', 'Cyclisme', 'Cyclist', 'Bikingman'],
        ],
        [
            'name' => 'Samir',
            'work' => 'Tennis',
            'image' => 'https://images.pexels.com/photos/28847134/pexels-photo-28847134/free-photo-of-young-man-sitting-outdoors-in-urban-setting.jpeg?auto=compress&cs=tinysrgb&w=600',
            'tags' => ['tennis'],
        ],
        [
            'name' => 'Amir',
            'work' => 'Running',
            'image' => 'https://images.pexels.com/photos/1300402/pexels-photo-1300402.jpeg?auto=compress&cs=tinysrgb&w=600',
            'tags' => ['jogging', 'running', 'run', 'jog', 'course', 'courses', 'marathon', 'marathons']
        ]
    ];


    public function __construct(TextTagger $textTagger)
    {
        $this->client = new Client();
        $this->textTagger = $textTagger;
    }

    public function normalizeTags(array $tags): array {
        // Create an empty array to hold the normalized tags
        $normalizedTags = [];
    
        // Loop through the input array
        foreach ($tags as $key => $value) {
            // Convert each value to lowercase and trim whitespace
            $normalizedValue = strtolower(trim($value));
            
            // Remove punctuation
            $normalizedValue = preg_replace("/[^\w\s]/", "", $normalizedValue);
            
            // Store the normalized value
            $normalizedTags[$key] = $normalizedValue;
        }
    
        return $normalizedTags;
    }

    public function scrape()
    {
        // List of URLs to scrape
        
        // Scrape data
$articles = [];
foreach ($this->urls as $urlInfo) {

    $crawler = $this->client->request('GET', $urlInfo['url']);

    // Scrape the articles
    $crawler->filter($urlInfo['urlData']['CSSSelector'])->each(function ($node, $index) use (&$articles, $urlInfo) {
        if ($index < 3) { // Only scrape the first three articles

            // Initialize article data
            $article = [];

            // Check for title
            $titleNode = $node->filter($urlInfo['urlData']['title']);
            if ($titleNode->count() > 0) {
                $article['title'] = $titleNode->text();
            } else {
                $article['title'] = 'Title not available';
            }

            // Check for body and coaches
            // Initialize article coaches as an empty array
            $article['coaches'] = [];

            
            $bodyNode = $node->filter($urlInfo['urlData']['body']);
            if ($bodyNode->count() > 0) {
                
                $article['body'] = $bodyNode->text();
                $article['tags'] = $this->textTagger->generateTags($article['body']);
                $article['tags'] = json_decode(json_encode($article['tags']), true);

                // Loop through the input array
                $article['tags'] = $this->normalizeTags($article['tags']);
                
                // Check for matches and add to article['coaches']
                foreach ($this->coaches as $coach) {
                    $coach['tags'] = $this->normalizeTags($coach['tags']);
                    if (array_intersect($coach['tags'], $article['tags'])) {
                     // Add both tag and name to the article's coaches
                     $article['coaches'][] = [
                         'name' => $coach['name'],
                         'image' => $coach['image'],
                         'work' => $coach['work'],
                     ];
                     $article['cat'] = $coach['work'];
                 }
             }
            } else {
                $article['body'] = 'Body not available';
            }

              // Check for link
              $linkNode = $node->filter($urlInfo['urlData']['a']); // Adjust the selector if you have a specific anchor tag to target
              if ($linkNode->count() > 0) {
                  $href = $linkNode->attr('href'); // Get the href attribute
                  
                  if (strpos($href, 'http') === 0) {
                    $article['link'] = $href; // Full URL, no need to modify
                } else {
                    $article['link'] = rtrim($urlInfo['url'], '/') . '/' . ltrim($href, '/'); // Prepend base URL to path
                }
                
                //   $article['link'] = $linkNode->attr('href'); // Get the href attribute
              } else {
                  $article['link'] = 'Link not available';
              }

            // Check for image src
            $imageNode = $node->filter($urlInfo['urlData']['img']);
            if ($imageNode->count() > 0) {
                if($urlInfo['urlData']['attr'] === 'onerror') {
                    $onerrorAttr = $imageNode->attr('onerror');
                
                    // Use regex to extract the fallback src from the onerror attribute
                    if (preg_match("/this\.src='(.*?)'/", $onerrorAttr, $matches)) {
                        $article['image'] = $matches[1]; // This will give you the fallback URL
                    }
                }
                else $article['image'] = $imageNode->attr($urlInfo['urlData']['attr']);
                
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