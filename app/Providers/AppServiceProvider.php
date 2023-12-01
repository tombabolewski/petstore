<?php

namespace App\Providers;

use App\Services\PetstoreApi\PetNormalizerService;
use App\Services\PetstoreApi\PetService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Configure Petstore API Client
        $this->app->singleton(PetService::class, function () {

            $client = Http::baseUrl(config('services.petstore.url'))
                ->timeout(config('services.petstore.timeout', 10))
                ->connectTimeout(config('services.petstore.connect_timeout', 2));
                //->withToken(config('services.petstore.token'));

            return new PetService($client, resolve(PetNormalizerService::class));
        });

        $this->app->singleton(PetNormalizerService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
