<?php

namespace Diarsa\LaravelWhereLike;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Diarsa\LaravelWhereLike\Commands\LaravelWhereLikeCommand;

class LaravelWhereLikeServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-where-like')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_where_like_table')
            ->hasCommand(LaravelWhereLikeCommand::class);
    }

    public function boot()
    {
        LaravelWhereLike::register();
    }
}
