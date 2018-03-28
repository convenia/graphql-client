<?php

namespace Convenia\GraphQLClient\Helpers;

/**
 * GraphQLUrlBuilder
 */
class GraphQLUrlBuilder
{
    protected $queryType;
    protected $enums;
    protected $baseUrl;
    protected $queryName;

    public function __construct($query)
    {
        $this->queryType = $query->queryType;
        $this->queryName = $query->getQueryName();
        $this->outputParams = $query->getOutputParams();
        $this->enums = $query->enums;
    }

    /**
     * Do the formatting of the input parameters and output fields into a GraphQL string
     *
     * @param  Array  $arguments Input Arguments to send
     * @param  Array  $fields    Desired output fields, optional. If null the variable $outputParams of every query or mutation will be used as desired output
     *
     * @return string  The graphQl query string
     */
    public function buildUrl(array $arguments, $fields = null)
    {
        $arguments = $this->buildArguments($arguments);

        if (is_null($fields)) {
            return "?query={$this->queryType}{{$this->queryName}({$arguments})}";
        }

        $fields = $this->buildFields($fields);

        return "?query={$this->queryType}{{$this->queryName}({$arguments}){{$fields}}}";
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

        return "?query={$this->queryType}{{$this->queryName}(id:{$id}, {$arguments}){{$fields}}}";
    }

    /**
     * @param  array $fields
     * @return string
     */
    public function buildListUrl($fields)
    {
        $fields = $this->buildFields($fields);

        return "?query={$this->queryType}{{$this->queryName}{{$fields}}}";
    }

    /**
     * @param int $id
     * @param  array $fields
     * @return string
     */
    public function buildSingleUrl($id, $fields)
    {
        $fields = $this->buildFields($fields);

        return "?query={$this->queryType}{{$this->queryName}(id:{$id}){{$fields}}}";
    }

    /**
     * @param  integer $limit  limit per page
     * @param  integer $page   page number
     * @param  array   $fields output fields
     * @return string
     */
    public function buildPaginateUrl($limit = 1, $page = 1, $fields)
    {
        $fields = $this->buildFIelds($fields);

        return "?query={$this->queryType}{{$this->queryName}(limit:{$limit},page:{$page}){data{{$fields}},total,per_page}}";
    }

    /**
     * @param  Arrray $data Input arguments to send
     * @return string S
     */
    protected function buildArguments($data)
    {
        $arguments = substr(json_encode($data, JSON_UNESCAPED_UNICODE), 1, -1);
        $arguments = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $arguments);

        if (empty($this->enums)) {
            return $arguments;
        }

        return $this->buildEnums($data, $arguments);
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

    protected function buildEnums($data, $arguments): string
    {
        $enums = array_intersect_key(
            $data,
            array_flip($this->enums)
        );

        $oldValues = array_map(function ($enum) {
            return '"'.$enum.'"';
        }, $enums);

        $oldValues = array_values($oldValues);
        $newValues = array_values($enums);

        return str_replace($oldValues, $newValues, $arguments);
    }

}
