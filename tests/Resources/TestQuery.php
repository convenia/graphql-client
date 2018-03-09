<?php

namespace Convenia\GraphQLClient\Tests\Resources;

use Convenia\GraphQLClient\Query;

class TestQuery extends Query
{
    protected $queryName = 'testQuery';

    protected $outputParams = [
        'id',
        'name',
        'description'
    ];
}
