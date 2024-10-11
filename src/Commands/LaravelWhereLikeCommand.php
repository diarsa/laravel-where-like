<?php

namespace Diarsa\LaravelWhereLike\Commands;

use Illuminate\Console\Command;

class LaravelWhereLikeCommand extends Command
{
    public $signature = 'laravel-where-like';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
