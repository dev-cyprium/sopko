<?php

namespace App\Providers;

use App\Repo\AccountRepository;
use App\Repo\Contracts\AccountContract;
use Illuminate\Support\ServiceProvider;
use App\Tools\Sopko;
use App\Repo\Contracts\CategoryContract;
use App\Repo\CategoryRepository;
use App\Repo\Contracts\ImageContract;
use App\Repo\ImageRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Sopko', function() { return new Sopko(); });
        $this->app->bind(AccountContract::class, AccountRepository::class);
        $this->app->bind(CategoryContract::class, CategoryRepository::class);
        $this->app->bind(ImageContract::class, ImageRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
