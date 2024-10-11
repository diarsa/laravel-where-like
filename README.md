# A Laravel package that provides an easy way to use query builder

[![Latest Version on Packagist](https://img.shields.io/packagist/v/diarsa/laravel-where-like.svg?style=flat-square)](https://packagist.org/packages/diarsa/laravel-where-like)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/diarsa/laravel-where-like/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/diarsa/laravel-where-like/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/diarsa/laravel-where-like/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/diarsa/laravel-where-like/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/diarsa/laravel-where-like.svg?style=flat-square)](https://packagist.org/packages/diarsa/laravel-where-like)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require diarsa/laravel-where-like
```

## Usage

In query builder, you can perform searches across multiple fields, including related models, using this method.

```php
use Diarsa\LaravelWhereLike\LaravelWhereLike;

$search = $request->search;
return User::where('status', 1)->whereLike(['name', 'address', 'categoryDetail.category_code', 'histories.device'], $search)->get();

```

Another methods.

```php
$laravelWhereLike = new Diarsa\LaravelWhereLike\LaravelWhereLike();
echo $laravelWhereLike->tambah(1, 4);

use Diarsa\LaravelWhereLike\LaravelWhereLike;
Route::get('calculate', function() {
    return LaravelWhereLike::tambah(1, 4);
});
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-where-like.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-where-like)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Credits

- [Bayu Diarsa](https://github.com/diarsa)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
