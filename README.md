# Multi Framework Cacher Script

[![Latest Version on Packagist](https://img.shields.io/packagist/v/fredbradley/cacher.svg?style=flat-square)](https://packagist.org/packages/fredbradley/cacher)
[![Build Status](https://img.shields.io/travis/fredbradley/multiframework-cacher/master.svg?style=flat-square)](https://travis-ci.org/fredbradley/multiframework-cacher)
![StyleCI Status](https://github.styleci.io/repos/278584366/shield)
[![Total Downloads](https://img.shields.io/packagist/dt/fredbradley/cacher.svg?style=flat-square)](https://packagist.org/packages/fredbradley/xirrusapi)

In my day job, I work regularly with both Laravel and WordPress. I also make packages that are needed to be compatible with both. It becomes a right pain, when it comes to caching, to write out if statements for each framework. So I created this small script which does that for me.    

## Installation

You can install the package via composer:

```bash
composer require fredbradley/cacher
```

## Usage

``` php
// Override default options
use FredBradley\Cacher;
Cacher::getAndSet('cache_key_name', 10, function() {
    // Your logic
    $value = "value";
    return $value;
});
```
There's only a small handful of methods in the one class. It's really basic, but amazingly wonderful!

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email code@fredbradley.co.uk instead of using the issue tracker.

## Credits

- [Fred Bradley](https://github.com/fredbradley)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
