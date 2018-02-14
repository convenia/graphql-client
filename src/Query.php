<?php

namespace Convenia\GraphQLClient;

use Convenia\GraphQLClient\Http\GraphQLRequest;
use Convenia\GraphQLClient\Helpers\GraphQLUrlBuilder;

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
        $url = new GraphQLUrlBuilder($this);
        $url = $url->buildListUrl($fields);

        return $this->send($url);
    }

    /**
     * @param int $id
     * @param  array  $fields
     * @return array
     */
    public function single($id, array $fields = [])
    {
        $url = new GraphQLUrlBuilder($this);
        $url = $url->buildSingleUrl($id, $fields);

        return $this->send($url);
    }

}
