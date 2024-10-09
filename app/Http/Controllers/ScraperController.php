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
        $data = [];
        // Scrape data
        $data = $this->scraper->scrape();
        
        // Return the data as a JSON response
        return response()->json($data);
    }
}