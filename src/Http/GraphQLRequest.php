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

    public function __construct(Client $client, $baseUrl, $headers = [])
    {
        $this->client = $client;
        $this->baseUrl = $baseUrl;
        $this->headers = $headers;
    }

    /**
     * Do the request to the GraphQL api
     *
     * @param  string $url GraphQL Url builded
     * @return array      The treated response
     */
    protected function send($url)
    {
        $response = new GraphQLResponse(
            $this->client->request('POST', $url, [
                'headers' => $this->headers
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
