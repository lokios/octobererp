#Api plugin

[![Build Status](https://scrutinizer-ci.com/g/gpasztor87/oc-api-plugin/badges/build.png?b=master)](https://scrutinizer-ci.com/g/gpasztor87/oc-api-plugin/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/gpasztor87/oc-api-plugin/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/gpasztor87/oc-api-plugin/?branch=master)
[![StyleCI](https://styleci.io/repos/50492303/shield)](https://styleci.io/repos/50492303)

Tools for building RESTful HTTP + JSON APIs for OctoberCMS.

## Introduction

This plugin provides two features

1. Console generator which creates Controller and Fractal Transformer in a single command.

2. Basic REST API skeleton that can be really helpful if you need something standard. It's 100% optional.

If you do not use Fractal for your transformation layer, this plugin is probably not the right choice for you.

## Installation

* Extract this repository into plugins/autumn/api
* In plugins/autumn/api folder run `composer install`.

## Usage

### Generator

The only console command that is added is ```artisan create:api <AuthorName>.<PluginName> <ModelName>```.

Imagine you need to create a rest api to list/create/update etc posts from Acme.Blog plugin. 
To achieve that you need to do lots of boilerplate operations - create controller, transformer, set up needed routes.

```php artisan create:api Acme.Blog Post``` does all the work for you.


1. The generator creates a routes.php which looks like that:

```php

<?php

    Route::group(['prefix' => 'api/v1'], function() {
        //
        Route::resource('posts', 'Acme\Blog\Controllers\Posts');
    });
    
```

2) The generator creates a controller that extends base api controller.
In the controller you can register your API endpoints via `$publicActions` property:

```php

<?php

namespace Acme\Blog\Http\Controllers;

use Acme\Blog\Models\Post;
use Acme\Blog\Http\Transformers\PostTransformer;
use Autumn\Api\Classes\ApiController;

class PostsController extends ApiController
{   
    /**
     * Eloquent model.
     *
     * @return \October\Rain\Database\Model
     */
    protected function model()
    {
        return new Post;
    }
    
    /**
     * Transformer for the current model.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    protected function transformer()
    {
        return new PostTransformer;
    }
}

```

You can customize this stub as much as you want.

3) Finally the generator creates a fractal Transformer

```php
<?php

namespace Acme\Blog\Http\Transformers;

use Acme\Blog\Models\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{   
    /**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform(Post $item)
    {
        return [
            'id'         => (int)$item->id,
            'created_at' => (string)$item->created_at,
            'updated_at' => (string)$item->updated_at,
        ];
    }
}

```

This stub is customizable too.

The list of routes that are available out of the box:

1. `GET api/v1/blog/posts`
2. `GET api/v1/blog/posts/{id}`
3. `POST api/v1/blog/posts`
4. `PUT api/v1/blog/posts/{id}`
5. `DELETE api/v1/blog/posts/{id}`

Request and response format is json
Fractal includes are supported via $_GET['include'].
Validation rules for create and update can be set by overwriting `rulesForCreate` and `rulesForUpdate` in your controller.

This skeleton is not a silver bullet but in many cases it can be either exactly what you need or can be used as a decent starting point for your api.

You can check https://github.com/gpasztor87/oc-api-plugin/blob/master/classes/ApiController.php for more info.

## Rate Limiting

Rate Limiting (throttling) allows you to limit the number of requests a client can make in a given amount of time.
A limit and the expiration time is defined by a throttle. By default the package has two throttles,
an authenticated throttle and an unauthenticated throttle.

### Enabling Rate Limiting

To enable rate limiting for a route or group of routes you must enable the api.throttle middleware.

```php
    Route::group(['prefix' => 'api/v1', 'middleware' => ['api.throttle:100,5']]], function() {
        // Routes
    });
```

This would set a request limit of 100 with an expiration time of 5 minutes for this group.
