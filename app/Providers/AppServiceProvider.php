<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->extend(\Faker\Generator::class, function ($faker) {
            $faker->addProvider(new \App\Faker\PostProvider($faker));

            return $faker;
        });

        $locale = config('app.faker_locale', 'en_US');
        $this->app->extend(\Faker\Generator::class.':'.$locale, function ($faker) {
            $faker->addProvider(new \App\Faker\PostProvider($faker));

            return $faker;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->make('request')->server->set('HTTPS', 'on');
        URL::forceScheme('https');
        Paginator::defaultView('components.paginator');
    }
}
