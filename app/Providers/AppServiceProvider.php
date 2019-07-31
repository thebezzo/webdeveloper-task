<?php

namespace App\Providers;

use App\Services\FileService;
use App\Utilities\PatternUtility;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when(FileService::class)
                  ->needs(PatternUtility::class)
                  ->give(function () {
                      return new PatternUtility('page{id}.json');
                  });
    }
}
