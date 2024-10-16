<?php

namespace App\Services;

use Phpml\Tokenization\WhitespaceTokenizer;

class TextTagger
{
    protected $tokenizer;

    public function __construct()
    {
        $this->tokenizer = new WhitespaceTokenizer();
    }

    public function generateTags($text)
    {
        // Tokenize the text
        $tokens = $this->tokenizer->tokenize($text);
        
        // Filter and get unique tags (e.g., words longer than 3 characters)
        $tags = array_unique(array_filter($tokens, function($token) {
            return strlen($token) > 3; // Adjust this as needed
        }));

        return $tags;
    }
}