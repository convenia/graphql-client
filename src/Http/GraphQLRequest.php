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

    public function __construct(Client $client, $baseUrl)
    {
        $this->client = $client;
        $this->baseUrl = $baseUrl;
    }

    /**
     * Do the request to the GraphQL api
     *
     * @param  string $url GraphQL Url builded
     * @return array      The treated response
     */
    protected function send($url)
    {
        $response = new GraphQLResponse($this->client->request('POST', $url), $this->queryName);

        return $response->getBody();
    }

    /**
     * @param  Arrray $data Input arguments to send
     * @return string S
     */
    protected function buildArguments($data)
    {
        $args = substr(json_encode($data, JSON_UNESCAPED_UNICODE), 1, -1);

        return preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $args);
    }

    /**
     * Do the formatting of the input parameters and output fields into a GraphQL string
     *
     * @param  Array  $arguments Input Arguments to send
     * @param  Array  $fields    Desired output fields, optional. If null the variable $outputParams of every query or mutation will be used as desired output
     *
     * @return string  The graphQl query string
     */
    protected function buildUrl(array $arguments, $fields = null)
    {
        $arguments = $this->buildArguments($arguments);

        if (is_null($fields)) {
            return "{$this->baseUrl}{$this->baseMutation}{{$this->queryName}({$arguments})}";
        }

        $fields = $this->buildFields($fields);

        return "{$this->baseUrl}{$this->baseMutation}{{$this->queryName}({$arguments}){{$fields}}}";
    }

    /**
     * Transforms the desired output fields into a json string
     *
     * @param  array  $fields Array containing all the desired output fields
     *
     * @return string
     */
    protected function buildFields($fields = [])
    {
        $fields = empty($fields) ? $this->outputParams : $fields;

        return implode(',', $fields);
    }
}
