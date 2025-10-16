# A Laravel package that provides an easy way to use query builder

[![Latest Version on Packagist](https://img.shields.io/packagist/v/diarsa/laravel-where-like.svg?style=flat-square)](https://packagist.org/packages/diarsa/laravel-where-like)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/diarsa/laravel-where-like/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/diarsa/laravel-where-like/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/diarsa/laravel-where-like/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/diarsa/laravel-where-like/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/diarsa/laravel-where-like.svg?style=flat-square)](https://packagist.org/packages/diarsa/laravel-where-like)

Search using Laravel's query builder across multiple fields, including related models, in a simple and efficient way.

## Installation

You can install the package via composer:

```bash
composer require diarsa/laravel-where-like
```

## Usage

### Without whereLike (Traditional Way)

Without this package, you would need to write complex queries with multiple `orWhere` and `orWhereHas` clauses:

```php
$search = $request->search;
return User::where('status', 1)
    ->where(function ($query) use ($search) {
        $query->where('name', 'LIKE', "%{$search}%")
              ->orWhere('address', 'LIKE', "%{$search}%")
              ->orWhereHas('categoryDetail', function ($query) use ($search) {
                  $query->where('category_code', 'LIKE', "%{$search}%");
              })
              ->orWhereHas('histories', function ($query) use ($search) {
                  $query->where('device', 'LIKE', "%{$search}%");
              });
    })
    ->get();
```

### With whereLike (Simplified Way)

With this package, you can perform searches across multiple fields, including related models, using this simple method:

```php
$search = $request->search;
return User::where('status', 1)
    ->whereLike(
        ['name', 'address', 'categoryDetail.category_code', 'histories.device'], 
        $search
    )
    ->get();
```

### More Examples

#### Searching in Multiple Fields

```php
// Search in user's basic fields
User::whereLike(['name', 'email', 'phone'], $searchTerm)->get();
```

#### Searching in Related Models

```php
// Search in user and their profile information
User::whereLike([
    'name', 
    'email', 
    'profile.bio', 
    'profile.location',
    'posts.title',
    'posts.content'
], $searchTerm)->get();
```

#### Searching with Additional Conditions

```php
// Combine with other query conditions
User::where('status', 'active')
    ->where('created_at', '>=', now()->subMonth())
    ->whereLike(['name', 'email', 'profile.bio'], $searchTerm)
    ->orderBy('created_at', 'desc')
    ->paginate(10);
```

### Additional Features

#### Mask Sensitive Data

The package also provides a `maskSensitiveData` macro for Laravel Collections to help you mask sensitive information:

```php
use Illuminate\Support\Collection;

$sensitiveData = collect(['john.doe@email.com', '081234567890', 'SecretPassword123']);

// Default masking (shows first 2 and last 2 characters)
$masked = $sensitiveData->map(function ($item) {
    return collect()->maskSensitiveData($item);
});
// Result: ['jo***@email.com', '08******7890', 'Se**********123']

// Custom masking (first 3 and last 1 characters)
$customMasked = $sensitiveData->map(function ($item) {
    return collect()->maskSensitiveData($item, 3, 1);
});
// Result: ['joh******.com', '083*******0', 'Sec**********3']
```

## Requirements

- PHP 8.1, 8.2, 8.3, or 8.4
- Laravel 9.x, 10.x, 11.x, or 12.x

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

You can support us by [Buy me a coffee](https://buymeacoffee.com/diarsa).

## Credits

- [Bayu Diarsa](https://github.com/diarsa)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
