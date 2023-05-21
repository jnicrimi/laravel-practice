<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Packages\Application\Comic\ComicIndexInteractor;
use Packages\Application\Comic\ComicShowInteractor;
use Packages\Domain\Comic\ComicRepositoryInterface;
use Packages\Infrastructure\Repository\Comic\ComicRepository;
use Packages\UseCase\Comic\Index\ComicIndexUseCaseInterface;
use Packages\UseCase\Comic\Show\ComicShowUseCaseInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ComicRepositoryInterface::class, ComicRepository::class);
        $this->app->bind(ComicIndexUseCaseInterface::class, ComicIndexInteractor::class);
        $this->app->bind(ComicShowUseCaseInterface::class, ComicShowInteractor::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Model::shouldBeStrict(! $this->app->isProduction());
    }
}
