<?php

namespace Convenia\GraphQLClient\Http;

use GuzzleHttp\Client;

abstract class GraphQLRequest
{
    /**
     * @var Client $client
     */
    protected $client;

    /**
     * @var array
     */
    protected $outputParams;

    /**
     * @var string $baseUrl
     */
    protected $baseUrl;

    /**
     * The query's name configured in each of every Query or Mutation implementations
     * @var string $queryName
     */
    protected $queryName;

    protected $headers;

    public $enums = [];

    public function __construct($baseUrl, $headers = [])
    {
        $this->baseUrl = $baseUrl;
        $this->client = new Client(['base_uri' => $baseUrl]);
        $this->headers = array_merge($headers, ['Content-Type' => 'application/json', 'Accept' => 'application/json']);
    }

    /**
     * Do the request to the GraphQL api
     *
     * @param  string $query GraphQL query build
     * @return array      The treated response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Convenia\GraphQLClient\Exceptions\GraphQLException
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

    /**
     * Return the BaseURL
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * Return the QueryName
     *
     * @return string
     */
    public function getQueryName()
    {
        return $this->queryName;
    }

    /**
     * Return the OutputParams
     *
     * @return array
     */
    public function getOutputParams()
    {
        return $this->outputParams;
    }
}
