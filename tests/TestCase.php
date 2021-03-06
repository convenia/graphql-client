<?php

namespace Convenia\GraphQLClient\Tests;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase as BaseTest;
use Convenia\GraphQLClient\Tests\Resources\TestQueryEnum;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\RequestOptions;
use Convenia\GraphQLClient\Tests\Resources\TestQuery;
use Convenia\GraphQLClient\Helpers\GraphQLUrlBuilder;
/**
 * Class TestCase
 */
abstract class TestCase extends BaseTest
{

    public $baseQuery;
    public $baseUrl = "http://testurl.com/v1/graphql";
    public $baseHeaders = [];
    public $queryEnum;

    public function setUp()
    {
        $this->baseQuery = new TestQuery($this->baseUrl, $this->baseHeaders);
        $this->queryEnum = new TestQueryEnum($this->baseUrl, $this->baseHeaders);
    }

    public function invokeMethod(&$object, $methodName, $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
