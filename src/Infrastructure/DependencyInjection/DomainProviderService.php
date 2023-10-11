<?php

namespace Core\Infrastructure\DependencyInjection;

use Core\Domain\User\Repository\UserRepositoryInterface;
use Core\Infrastructure\Persistence\Eloquent\UserRepository;
use Illuminate\Support\ServiceProvider;

class DomainProviderService extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
