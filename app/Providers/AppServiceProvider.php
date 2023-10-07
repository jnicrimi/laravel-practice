<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Packages\Application\Comic\ComicIndexInteractor;
use Packages\Application\Comic\ComicShowInteractor;
use Packages\Application\Comic\ComicStoreInteractor;
use Packages\Application\Comic\ComicUpdateInteractor;
use Packages\Domain\Comic\ComicRepositoryInterface;
use Packages\Infrastructure\Repository\Comic\ComicRepository;
use Packages\UseCase\Comic\Index\ComicIndexUseCaseInterface;
use Packages\UseCase\Comic\Show\ComicShowUseCaseInterface;
use Packages\UseCase\Comic\Store\ComicStoreUseCaseInterface;
use Packages\UseCase\Comic\Update\ComicUpdateUseCaseInterface;

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
        $this->app->bind(ComicStoreUseCaseInterface::class, ComicStoreInteractor::class);
        $this->app->bind(ComicIndexUseCaseInterface::class, ComicIndexInteractor::class);
        $this->app->bind(ComicShowUseCaseInterface::class, ComicShowInteractor::class);
        $this->app->bind(ComicUpdateUseCaseInterface::class, ComicUpdateInteractor::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Model::shouldBeStrict(! $this->app->isProduction());
        JsonResource::withoutWrapping();
    }
}
