<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Packages\Application\Comic\ComicDestroyInteractor;
use Packages\Application\Comic\ComicIndexInteractor;
use Packages\Application\Comic\ComicShowInteractor;
use Packages\Application\Comic\ComicStoreInteractor;
use Packages\Application\Comic\ComicUpdateInteractor;
use Packages\Domain\Comic\ComicRepositoryInterface;
use Packages\Infrastructure\Repository\Comic\ComicRepository;
use Packages\Infrastructure\Service\Notification\ComicNotificationService;
use Packages\Infrastructure\Service\Notification\SlackNotificationService;
use Packages\UseCase\Comic\Destroy\ComicDestroyUseCaseInterface;
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
        $this->app->bind(ComicDestroyUseCaseInterface::class, ComicDestroyInteractor::class);
        $this->app->bind(SlackNotificationService::class, function () {
            return new SlackNotificationService();
        });
        $this->app->bind(ComicNotificationService::class, function () {
            return new ComicNotificationService();
        });
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
