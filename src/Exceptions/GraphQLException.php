<?php

namespace Convenia\GraphQLClient\Exceptions;

class GraphQLException
{
    /**
     * var array
     */
    protected $error;

    public function __construct($errors)
    {
        $this->errors = $errors;
    }

    /**
     * Get's every error returned by the request
     * @return stdClass
     */
    public function getErrors()
    {
        $errors = $this->mapErrors();

        return [
            'message' => 'One or more errors have occurred',
            'errors' => $errors
        ];
    }

    /**
     * Maps every error into a single array
     * @return array
     */
    protected function mapErrors()
    {
        return array_map(function($error) {
            return $error['message'];
        }, $this->errors);
    }
}
