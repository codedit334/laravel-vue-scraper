<?php

namespace App\Http\Controllers;
use App\Services\WebScraper;


use Illuminate\Http\Request;

class ScraperController extends Controller
{
    public function show()
    {
        $sportmadata = [
            'image' => 'https://sportma.com/wp-content/uploads/2021/06/sportma-logo-300x300.png',
            'title' => 'Sportma.ma',
            'price' => '300'
        ];
        return view('sportma');
    }
}


?>