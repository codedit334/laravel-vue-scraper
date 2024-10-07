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
        $url = $request->input('url');
        $data = $this->scraper->scrape($url);

        return response()->json($data);
    }
}