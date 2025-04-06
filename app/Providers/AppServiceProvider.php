<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\Factory;
use App\Socialite\HuggyProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->bootHuggySocialite();
    }

    private function bootHuggySocialite()
{
    $socialite = $this->app->make('Laravel\Socialite\Contracts\Factory');
    $socialite->extend(
        'huggy',
        function ($app) use ($socialite) {
            $config = $app['config']['services.huggy'];
            return $socialite->buildProvider(HuggyProvider::class, $config);
        }
    );
}
}
