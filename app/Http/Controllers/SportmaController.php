<?php

namespace App\Http\Controllers;
use App\Services\WebScraper;


use Illuminate\Http\Request;

class ScraperController extends Controller
{
    public function show()
    {
        return view('sportma');
    }
}


?>