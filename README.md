# PHP GraphQL Client

This package allows you to make GraphQL requests using pure PHP.

## Implementation

The package has two basic classes, `Query` and `Mutation` that needs to be used when implementing a query or a mutation. In both cases you need to pass an instance of `GuzzleHttp\Client` and the base url. Every query or mutation needs also to set the name and desired output parameters.

### Example

```php

use Convenia\GraphQLClient\Mutation;

class UpdateUserMutation extends Mutation
{
    protected $queryName = 'createUser';

    protected $outputParams = [
        'id',
        'name',
        'last_name'
    ];
}

```

## Usage

When calling the mutation's methods you can choose between using the output params setted in the model, or you can also pass the desired params.

### Example

```php
class User
{
    protected $client = new GuzzleHttp\Client();

    protected $baseUrl = 'http://www.mygraphqlapi/v1/graphql'

    public static function create($userId, $data, $returnParams = [])
    {
        $mutation = new UpdateUserMutation($this->baseUrl);

        $mutation->update($userId, $data, $returnParams);
    }
}
```

### Responses

This package has a handler that deals with the response. This response class also deals with the possible GraphQL errors.
