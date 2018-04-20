<?php

namespace Convenia\GraphQLClient;

use Convenia\GraphQLClient\Http\GraphQLRequest;
use Convenia\GraphQLClient\Helpers\GraphQLPayloadBuilder;

class Mutation extends GraphQLRequest
{

    /**
     * @var string
     */
    public $queryType = 'mutation';

    /**
     * Create an mutation
     *
     * @param array $arguments
     * @param array|null $fields
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws Exceptions\GraphQLException
     */
    public function create(array $arguments, array $fields = null)
    {
        return $this->mutate($arguments, $fields);
    }

    /**
     * Create a update mutation
     *
     * @param $id
     * @param array $arguments
     * @param array|null $fields
     * @return array
     * @throws Exceptions\GraphQLException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update($id, array $arguments, array $fields = null)
    {
        $builder = new GraphQLPayloadBuilder($this);
        $payload = $builder->buildUpdate($id, $arguments, $fields);

        return $this->send($payload);
    }

    /**
     * Do the mutation
     *
     * @param  array $arguments
     * @param  array|null $fields
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws Exceptions\GraphQLException
     */
    public function mutate(array $arguments, array $fields = null)
    {
        $builder = new GraphQLPayloadBuilder($this);
        $payload = $builder->buildGraph($arguments, $fields);

        return $this->send($payload);
    }

    /**
     * Do the mutation without Params
     *
     * @param array $arguments
     * @return array
     * @throws Exceptions\GraphQLException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function mutateWithoutParams(array $arguments)
    {
        $builder = new GraphQLPayloadBuilder($this);
        $payload = $builder->buildGraphWithoutFields($arguments);

        return $this->send($payload);
    }
}
