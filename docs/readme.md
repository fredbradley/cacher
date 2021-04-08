# Welcome
In my day job, I work regularly with both Laravel and WordPress. I also make packages that are needed to be compatible with both. It becomes a right pain, when it comes to caching, to write out if statements for each framework. So I created this small script which does that for me.

## Installation

You can install the package via composer:

```bash
composer require fredbradley/cacher
```

## Usage
There are currently three methods:
### Example
``` php
use FredBradley\Cacher;

// Set and/or Get an item from the cache
Cacher::remember('cache_key_name', 300, function() {
    // Your logic
    $value = "value";
    return $value;
});
/*
 * Will set the value of 'cache_key_name' to the return value of the Closure callback and 
 * save in the cache for 5 minutes (300 seconds)
 */

// Forget/Delete an item from the cache
Cacher::forget('cache_key_name');

// Get an item from the cache
Cacher::get('cache_key_name');
```

Currently this is set to work seemlessly with Laravel and WordPress. Open to pull requests for other frameworks too.

There's only a small handful of methods in the one class. It's really basic, but amazingly wonderful!
