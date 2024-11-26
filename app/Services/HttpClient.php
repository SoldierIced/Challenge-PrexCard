<?php

namespace App\Services;

use App\Utils\RequestHandler;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Exception;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class HttpClient
{
    protected $client;
    protected $baseUri;
    public function __construct(string $baseUri, int $timeout = 60)
    {
        $this->baseUri = $baseUri;
        $this->client = new Client([
            'base_uri' => $baseUri,
            'timeout' => $timeout,
            'verify' => public_path('cacert.pem'), // Path to the SSL certificate
        ]);
    }

    public function get(string $endpoint, array $query = []): array
    {
        $url = $this->baseUri . $endpoint;
        try {
            $response = $this->client->get($endpoint, [
                'query' => $query,
            ]);

            $json = json_decode($response->getBody()->getContents(), true);
            RequestHandler::saveRequest($url, $query, $response->getStatusCode(), $json);
            return $json;
        } catch (RequestException $e) {

            $statusCode = $e->getResponse() ? $e->getResponse()->getStatusCode() : 500; // Default to 500 if no response
            $responseBody = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : null;
            $responseBody = $responseBody == null && $e->getMessage() ? ["error" => $e->getMessage()] : $responseBody;
            RequestHandler::saveRequest($url, $query, $statusCode, $responseBody, true);
            throw new Exception("HttpClient Error: " . $e->getMessage(), $statusCode, $e);
        }
    }
}
