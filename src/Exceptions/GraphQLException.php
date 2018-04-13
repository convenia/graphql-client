<?php

namespace Convenia\GraphQLClient\Exceptions;

use Exception;

class GraphQLException extends Exception
{
    /**
     * var array
     */
    protected $errors;

    public function __construct($errors, $code = 200, Exception $previous = null)
    {
        $this->errors = $errors;
        parent::__construct($this->getErrors(), $code, $previous);
    }

    /**
     * Get's every error returned by the request
     * @return stdClass
     */
    protected function getErrors()
    {
        $errors = $this->mapErrors();

        return json_encode([
            'message' => 'One or more errors have occurred',
            'errors' => $errors
        ]);
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
