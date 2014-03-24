# cache-file [![Build Status](https://secure.travis-ci.org/kevva/cache-file.png?branch=master)](http://travis-ci.org/kevva/cache-file)

Store and get files from cache with Node.js.

## Getting started

Install with [npm](https://npmjs.org/package/cache-file): `npm install cache-file`

## Examples

```js
var cache = require('cache-file');

// store test.jpg inside a test folder in cache
cache.store('test.jpg');

// get test.jpg from cache and save it as test-restored.jpg
cache.get('test.jpg', 'test-restored.jpg');

// check if test.jpg exists in cache
cache.check('test.jpg');

// get the path to test.jpg in cache
cache.path('test.jpg');

// remove test.jpg from cache
cache.clean('test.jpg');
```

## API

### .store(src, dest)

Store a file inside cache. Use `dest` to specify a custom name.

### .get(src, dest)

Get a cached file and save it to a desired location.

### .check(src)

Check if a cached file exists.

### .path(src)

Get the path to a cached file.

### .clean(src)

Remove a file from cache.

## License

[MIT License](http://en.wikipedia.org/wiki/MIT_License) (c) [Kevin Mårtensson](http://kevinmartensson.com)
