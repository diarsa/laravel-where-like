<?php

namespace Diarsa\LaravelWhereLike\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Diarsa\LaravelWhereLike\LaravelWhereLike
 */
class LaravelWhereLike extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Diarsa\LaravelWhereLike\LaravelWhereLike::class;
    }
}
