<?php

namespace Convenia\GraphQLClient;

use Convenia\GraphQLClient\Http\GraphQLRequest;

class Query extends GraphQLRequest
{
    /**
     * @var string
     */
    protected $queryName;

    /**
     * @var string
     */
    protected $baseQuery = '/v1/graphql?query=query';

    /**
     *
     * @param  array  $fields
     * @return array
     */
    public function list(array $fields = [])
    {
        $url = $this->buildListUrl($fields);

        return $this->send($url);
    }

    /**
     * @param int $id
     * @param  array  $fields
     * @return array
     */
    public function single($id, array $fields = [])
    {
        $url = $this->buildSingleUrl($id, $fields);

        return $this->send($url);
    }

    /**
     * @param  array $fields
     * @return string
     */
    private function buildListUrl($fields)
    {
        $fields = $this->buildFields($fields);

        return "{$this->baseQuery}{{$this->queryName}{{$fields}}}";
    }

    /**
     * @param int $id
     * @param  array $fields
     * @return string
     */
    private function buildSingleUrl($id, $fields)
    {
        $fields = $this->buildFields($fields);

        return "{$this->baseQuery}{{$this->queryName}(id:{$id}){{$fields}}}";
    }
}
