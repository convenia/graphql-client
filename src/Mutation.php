<?php

namespace Convenia\GraphQLClient;

use Convenia\GraphQLClient\Http\GraphQLRequest;

class Mutation extends GraphQLRequest
{
    /**
     * @var string
     */
    protected $baseMutation = '/v1/graphql?query=mutation';

    /**
     * @param  int     $id
     * @param  array      $arguments
     * @param  array|null $fields
     * @return array
     */
    public function update($id, array $arguments, array $fields = null)
    {
        $url = $this->buildUpdateUrl($id, $arguments, $fields);

        return $this->send($url);
    }

    /**
     * @param  array      $arguments
     * @param  array|null $fields
     * @return array
     */
    public function mutate(array $arguments, array $fields = null)
    {
        $url = $this->buildUrl($arguments, $fields);

        return $this->send($url);
    }

    /**
     * @param  int $id
     * @param  array  $arguments
     * @param  array|null $fields
     * @return String
     */
    public function buildUpdateUrl($id, array $arguments, $fields = null)
    {
        $arguments = $this->buildArguments($arguments);
        $fields = $this->buildFields($fields);

        return "{$this->baseUrl}{$this->baseMutation}{{$this->queryName}(id:{$id}, {$arguments}){{$fields}}}";
    }

}
