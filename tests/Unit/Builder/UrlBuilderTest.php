<?php

namespace Convenia\GraphQLClient\Tests\Unit\Builder;

use Convenia\GraphQLClient\Helpers\GraphQLUrlBuilder;
use Convenia\GraphQLClient\Tests\TestCase;

class UrlBuilderTest extends TestCase
{
    protected $builder;

    protected $testArray = ['first', 'second', 'third'];

    protected $testArguments = [
        'name' => 'Input name',
        'description' => 'Input description'
    ];

    public function setUp()
    {
        parent::setUp();
        $this->builder = new GraphQLUrlBuilder($this->baseQuery);
    }

    public function test_build_fields_method()
    {
        $fields = $this->invokeMethod($this->builder, 'buildFields', [$this->testArray]);
        $this->assertEquals('first,second,third', $fields);
    }

    public function test_build_arguments_method()
    {
        $arguments = $this->invokeMethod($this->builder, 'buildArguments', [$this->testArguments]);
        $this->assertEquals('name:"Input name",description:"Input description"', $arguments);
    }

    public function test_build_url_without_fields()
    {
        $url = $this->builder->buildUrl($this->testArray);
        $expectedUrl = '?query=query{testQuery("first","second","third")}';
        $this->assertEquals($expectedUrl, $url);
    }

    public function test_build_url_with_fields()
    {
        $fields = ['fourth', 'fifth', 'sixth'];
        $url = $this->builder->buildUrl($this->testArray, $fields);
        $expectedUrl = '?query=query{testQuery("first","second","third"){fourth,fifth,sixth}}';
        $this->assertEquals($expectedUrl, $url);
    }

    public function test_build_list_url_with_empty_fields()
    {
        $url = $this->builder->buildListUrl([]);
        $expectedUrl = '?query=query{testQuery{id,name,description}}';

        $this->assertEquals($expectedUrl, $url);
    }

    public function test_build_list_url_with_input_fields()
    {
        $url = $this->builder->buildListUrl($this->testArray);
        $expectedUrl = '?query=query{testQuery{first,second,third}}';
        $this->assertEquals($expectedUrl, $url);
    }

    public function test_build_single_url_with_empty_fields($value='')
    {
        $url = $this->builder->buildSingleUrl(1, []);
        $expectedUrl = '?query=query{testQuery(id:1){id,name,description}}';
        $this->assertEquals($expectedUrl, $url);
    }

    public function test_build_single_url_with_input_fields()
    {
        $url = $this->builder->buildSingleUrl(1, $this->testArray);
        $expectedUrl = '?query=query{testQuery(id:1){first,second,third}}';
        $this->assertEquals($expectedUrl, $url);
    }

    public function test_build_update_url_with_empty_fields()
    {
        $url = $this->builder->buildUpdateUrl(1, $this->testArguments, []);
        $expectedUrl = '?query=query{testQuery(id:1, name:"Input name",description:"Input description"){id,name,description}}';
        $this->assertEquals($expectedUrl, $url);
    }

    public function test_build_update_url_with_input_fields()
    {
        $url = $this->builder->buildUpdateUrl(1, $this->testArguments, $this->testArray);
        $expectedUrl = '?query=query{testQuery(id:1, name:"Input name",description:"Input description"){first,second,third}}';
        $this->assertEquals($expectedUrl, $url);
    }

    public function test_paginate_url_with_empty_fields()
    {
        $url = $this->builder->buildPaginateUrl(5, 1, []);
        $expectedUrl = "?query=query{testQuery(limit:5,page:1){data{id,name,description},total,per_page}}";
        $this->assertEquals($expectedUrl, $url);
    }

    public function test_paginate_url_with_input_fields()
    {
        $url = $this->builder->buildPaginateUrl(5, 1, $this->testArray);
        $expectedUrl = "?query=query{testQuery(limit:5,page:1){data{first,second,third},total,per_page}}";
        $this->assertEquals($expectedUrl, $url);
    }

    public function test_build_with_enum()
    {
        $testArguments = [
            'name' => 'Input name',
            'description' => 'Input description',
            'gender' => 'MALE'
        ];
        $builder = new GraphQLUrlBuilder($this->queryEnum);
        $url = $builder->buildUrl($testArguments);
        $expectedUrl = '?query=query{testQuery(name:"Input name",description:"Input description",gender:MALE)}';
        $this->assertEquals($expectedUrl, $url);
    }
}
