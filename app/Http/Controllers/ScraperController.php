<?php

namespace App\Http\Controllers;
use App\Services\WebScraper;


use Illuminate\Http\Request;

class ScraperController extends Controller
{
    protected $scraper;

    public function __construct(WebScraper $scraper)
    {
        $this->scraper = $scraper;
    }

    public function scrape(Request $request)
    {
        // $data = $this        ->scraper->scrape($urls);

        $urls = []; // Populate this array with your URLs
        $data = [];

        foreach ($urls as $url) {
            $scrapedData = $this->scraper->scrape($url);
            $data[] = $scrapedData; // Add the scraped data to the $data array
        }
        
        return response()->json($data);
    }
}