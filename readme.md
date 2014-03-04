# Delegator

A nice API helper, for Laravel, to keep your responses RESTed.
It blends in with the usual Response of Laravel.

## Installation

You can install this package through Composer.

```js
"require-dev": {
    "by-cedric/delegator": "dev-master"
}
```

Delegator extends the basic Response facade of Laravel.
So you need to use the Delegator's version of the Response facade.
Ofcourse you can still use the standard functions of Response.

In your config/app.php search for this line:

```php
'aliases' => array(
    ...
    'Response'        => 'Illuminate\Support\Facades\Response',
    ...
)
```

And replace it with:

```php
'aliases' => array(
    ...
    'Response'        => 'ByCedric\Delegator\Delegator',
    ...
)
```

## Basic Usage

You can use Delegator as simple as:

```php
Response::api();
```

This initiates a new Delegator, that is actually is a Response object.
So when you are done setting your response, you can just return it as a normal response:

```php
public function show( $id )
{
    $task = Task::find($id);
      
    return Response::api($task);
}
```

## Functions

All functions are chainable.
A new Delegator instance is created using the Response facade:

```php
Response::api();
```

You can use one of the following functions, as chained methods, to manipulate the response.

### code

Within a normal response, there is always a status code to explain the basic situation.

It accepts an integer.

```php
Response::api()->code(403);
```
  
### message

An API response is often read by developers, when developing their application.
During the development process, a lot can go wrong.
So it is always recomended to provide a human readable message.

It accepts a string.

```php
Response::api()->message('Please specify a valid API key.');
```

### data

An API response is almost all the time filled with data.
No need for explaination I think...

It accepts an array, or any object that implements the ArrayableInterface.

```php
Response::api()->data($task);
```

Note that the constructor of the Delegator also accepts data, exactly the same way.

```php
Response::api($task);
```

### callback

Not all the time a simple JSON request can be made.
Then you will just have to use the JSONP response.

It accepts a string.

```php
Response::api()->callback('loaded_call');
```

### error

When an error occures, you probably want it responded asap.
The error takes care of the human readable message and the http status code.

It accepts a string and integer.

```php
Response::api()->error('Could not find task with id #'. $id, 404);
```

### limit

When responding with a collection, info about the amount of items that can be returned at once is very useful.
For example, you can build your pagination with it.

It accepts an integer, or boolean to remove any set value.

```php
Response::api()->limit(100);
```

### offset

When responding with a collection, info about the current offset of the total collection is very useful.
For example, you can build your pagination with it.

```php
Response::api()->offset(45);
```

### count

When responding with a collection, info about the total amount of items in existence is very useful.
For example, you can build your pagination with it.

```php
Response::api()->count(231);
```

### mockCode

Some (old) clients are very clumsy with errors in the http status code.
When this is the case, it is best to let the client relax for a bit.
This will always pass http status code 200, only the code within the response is the real one.

It accepts a boolean, mostly used to disable it again.

```php
Response::api()->code(404)->mockCode();
```
