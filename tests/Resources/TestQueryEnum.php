<?php

namespace Convenia\GraphQLClient\Tests\Resources;

use Convenia\GraphQLClient\Query;

class TestQueryEnum extends Query
{
    protected $queryName = 'testQuery';

    protected $outputParams = [
        'id',
        'name',
        'description',
        'gender'
    ];

    public $enums = [
        'gender'
    ];
}
