<?php

namespace Convenia\GraphQLClient\Http;

use GuzzleHttp\Client;
use Convenia\GraphQLClient\Http\GraphQLResponse;

abstract class GraphQLRequest
{
    /**
     * @var GuzzleHttp\Client $client
     */
    protected $client;

    /**
     * @var string $baseUrl
     */
    protected $baseUrl;

    /**
     * The query's name setted in each of every Query or Mutation implementations
     * @var string $queryName
     */
    protected $queryName;

    protected $headers;

    public $enums = [];

    public function __construct($baseUrl, $headers = [])
    {
        $this->baseUrl = $baseUrl;
        $this->client = new Client(['base_uri'=> $baseUrl]);
        $this->headers = array_merge($headers, ['Content-Type' => 'application/json', 'Accept' => 'application/json']);
    }

    /**
     * Do the request to the GraphQL api
     *
     * @param  string $query GraphQL query builded
     * @return array      The treated response
     */
    protected function send($query)
    {
        $response = new GraphQLResponse(
            $this->client->request('POST', '', [
                'headers' => $this->headers,
                'json' => [
                    'query' => $query
                ]
            ]),
            $this->queryName);

        return $response->getBody();
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    public function getQueryName()
    {
        return $this->queryName;
    }

    public function getOutputParams()
    {
        return $this->outputParams;
    }
}