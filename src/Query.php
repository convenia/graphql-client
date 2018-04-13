<?php

namespace Convenia\GraphQLClient;

use Convenia\GraphQLClient\Http\GraphQLRequest;
use Convenia\GraphQLClient\Helpers\GraphQLPayloadBuilder;

class Query extends GraphQLRequest
{
    /**
     * @param  int     $id
     * @param  array      $arguments
     * @param  array|null $fields
     * @return array
     */
    public $queryType = 'query';

    /**
     *
     * @param  array  $fields
     * @return array
     */
    public function list(array $fields = [])
    {
        $payload = new GraphQLPayloadBuilder($this);
        $payload = $payload->buildList($fields);

        return $this->send($payload);
    }

    /**
     * @param int $id
     * @param  array  $fields
     * @return array
     */
    public function single($id, array $fields = [])
    {
        $payload = new GraphQLPayloadBuilder($this);
        $payload = $payload->buildSingle($id, $fields);

        return $this->send($payload);
    }

    /**
     * @param  integer $limit
     * @param  integer $page
     * @param  array   $fields
     * @return array
     */
    public function paginate($limit = 1, $page = 1, array $fields)
    {
        $payload = new GraphQLPayloadBuilder($this);
        $payload = $payload->buildPaginate($limit, $page, $fields);

        return $this->send($payload);
    }

    /**
     * @param array $arguments
     * @param array $fields
     * @param int $limit
     * @param int $page
     * @return array
     */
    public function search(array $arguments, array $fields, $limit = 1, $page = 1)
    {
        $payload = new GraphQLPayloadBuilder($this);
        $payload = $payload->buildSearch($limit, $page, $arguments, $fields);

        return $this->send($payload);
    }
}
