<?php

namespace App\Providers;

use App\Repositories\Contracts\IUserRepository;
use App\Services\Contracts\IGoogleAuthConfService;
use App\Services\Contracts\IGoogleClientService;
use App\Services\Contracts\IGoogleOAuth2Service;
use App\Services\Contracts\IUserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IGoogleAuthConfService::class, IGoogleAuthConfService::class);
        $this->app->bind(IGoogleClientService::class, IGoogleClientService::class);
        $this->app->bind(IGoogleOAuth2Service::class, IGoogleOAuth2Service::class);
        $this->app->bind(IUserRepository::class, IUserRepository::class);
        $this->app->bind(IUserService::class, IUserService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

}

