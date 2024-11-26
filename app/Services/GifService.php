<?php

namespace App\Services;

use Exception;

class GifService
{
    protected $httpClient;
    protected $giphyApiKey;

    public function __construct()
    {
        $this->httpClient = new HttpClient('https://api.giphy.com/v1/gifs/');
        $this->giphyApiKey = env('GIPHY_KEY');
    }

    public function searchGifs($query, $limit = 25, $offset = 0)
    {

        $response = $this->httpClient->get('search', [
            'api_key' => $this->giphyApiKey,
            'q' => $query,
            'limit' => $limit,
            'offset' => $offset,
        ]);

        return $response;
    }

    public function getGifById($id)
    {
        $response = $this->httpClient->get($id, [
            'api_key' => $this->giphyApiKey,
        ]);

        return $response;
    }

    public function saveGif($data)
    {
        // Future implementation for saving GIFs
    }
}
