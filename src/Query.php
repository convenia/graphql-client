<?php

namespace Convenia\GraphQLClient;

use Convenia\GraphQLClient\Http\GraphQLRequest;
use Convenia\GraphQLClient\Helpers\GraphQLPayloadBuilder;

class Query extends GraphQLRequest
{
    /**
     * @var string
     */
    public $queryType = 'query';

    /**
     * Build a list request and returns the response
     *
     * @param  array $fields
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws Exceptions\GraphQLException
     */
    public function list(array $fields = [])
    {
        $payload = new GraphQLPayloadBuilder($this);
        $payload = $payload->buildList($fields);

        return $this->send($payload);
    }

    /**
     * Build a single requests and return the response
     *
     * @param int $id
     * @param  array $fields
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws Exceptions\GraphQLException
     */
    public function single($id, array $fields = [])
    {
        $payload = new GraphQLPayloadBuilder($this);
        $payload = $payload->buildSingle($id, $fields);

        return $this->send($payload);
    }

    /**
     * Build a paginate requests and return the response
     *
     * @param  integer $limit
     * @param  integer $page
     * @param  array $fields
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws Exceptions\GraphQLException
     */
    public function paginate($limit = 1, $page = 1, array $fields)
    {
        $payload = new GraphQLPayloadBuilder($this);
        $payload = $payload->buildPaginate($limit, $page, $fields);

        return $this->send($payload);
    }

    /**
     * Build a paginate search and returns the response
     *
     * @param array $arguments
     * @param array $fields
     * @param int $limit
     * @param int $page
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws Exceptions\GraphQLException
     */
    public function search(array $arguments, array $fields, $limit = 1, $page = 1)
    {
        $payload = new GraphQLPayloadBuilder($this);
        $payload = $payload->buildSearch($limit, $page, $arguments, $fields);

        return $this->send($payload);
    }
}
