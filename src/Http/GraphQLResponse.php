<?php

namespace Convenia\GraphQLClient\Http;

use GuzzleHttp\Psr7\Response;
use Convenia\GraphQLClient\Exceptions\GraphQLException;

/**
 * GraphQLResponse
 */
class GraphQLResponse
{
    /**
     * var GuzzleHttp\Psr7\Response;
     */
    protected $response;

    /**
     * The query name, this field should be configured in each mutation or query implemented
     *
     * @var string
     */
    protected $queryName;

    public function __construct(Response $response, $queryName)
    {
        $this->response = $response;
        $this->queryName = $queryName;
    }

    /**
     * Gets the effective response
     *
     * @return array
     * @throws GraphQLException
     */
    public function getBody()
    {
        return $this->handle($this->response);
    }

    /**
     * Handles the response success or error
     *
     * @param  Response $response
     * @return array
     * @throws GraphQLException
     */
    protected function handle($response)
    {
        $decoded = $this->decodeResponse($response);

        if (array_key_exists('errors', $decoded)) {
            throw new GraphQLException($decoded['errors'], $response->getStatusCode());
        }

        return $decoded['data'][$this->queryName];
    }

    /**
     * Decodes the JSON response from GraphQL api
     *
     * @param string $response
     * @return array
     */
    protected function decodeResponse(string $response)
    {
        $response = $response->getBody()->getContents();

        return json_decode($response, true);
    }
}
