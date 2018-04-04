<?php

namespace Convenia\GraphQLClient;

use Convenia\GraphQLClient\Http\GraphQLRequest;
use Convenia\GraphQLClient\Helpers\GraphQLPayloadBuilder;

class Mutation extends GraphQLRequest
{
    /**
     * @param  int     $id
     * @param  array      $arguments
     * @param  array|null $fields
     * @return array
     */
    public $queryType = 'mutation';

    public function create(array $arguments, array $fields = null)
    {
        return $this->mutate($arguments, $fields);
    }

    public function update($id, array $arguments, array $fields = null)
    {
        $builder = new GraphQLPayloadBuilder($this);
        $payload = $builder->buildUpdate($id, $arguments, $fields);

        return $this->send($payload);
    }

    /**
     * @param  array      $arguments
     * @param  array|null $fields
     * @return array
     */
    public function mutate(array $arguments, array $fields = null)
    {
        $builder = new GraphQLPayloadBuilder($this);
        $payload = $builder->buildGraph($arguments, $fields);

        return $this->send($payload);
    }

}
