<?php

declare(strict_types=1);

namespace Packages\Application\Comic;

use Exception;
use Illuminate\Support\Facades\DB;
use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicRepositoryInterface;
use Packages\Infrastructure\Service\Notification\ComicNotificationService;
use Packages\UseCase\Comic\Destroy\ComicDestroyRequest;
use Packages\UseCase\Comic\Destroy\ComicDestroyResponse;
use Packages\UseCase\Comic\Destroy\ComicDestroyUseCaseInterface;
use Packages\UseCase\Comic\Exception\ComicCannotBeDeletedException;
use Packages\UseCase\Comic\Exception\ComicNotFoundException;

class ComicDestroyInteractor implements ComicDestroyUseCaseInterface
{
    /**
     * Constructor
     *
     * @param ComicRepositoryInterface $comicRepository
     */
    public function __construct(private readonly ComicRepositoryInterface $comicRepository)
    {
    }

    /**
     * @param ComicDestroyRequest $request
     *
     * @throws ComicNotFoundException
     * @throws ComicCannotBeDeletedException
     * @throws Exception
     *
     * @return ComicDestroyResponse
     */
    public function handle(ComicDestroyRequest $request): ComicDestroyResponse
    {
        $comicId = new ComicId($request->getId());
        $comicEntity = $this->comicRepository->find($comicId);
        if ($comicEntity === null) {
            throw new ComicNotFoundException('Comic not found');
        }
        if (! $comicEntity->canDelete()) {
            throw new ComicCannotBeDeletedException('Comic cannot be deleted');
        }

        try {
            DB::beginTransaction();
            $this->notifyComicDestroy($comicEntity);
            $this->comicRepository->delete($comicEntity);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
        $response = new ComicDestroyResponse();
        $response->setComic($comicEntity);

        return $response;
    }

    /**
     * @param Comic $comic
     *
     * @return void
     */
    private function notifyComicDestroy(Comic $comic): void
    {
        $service = new ComicNotificationService($this->comicRepository);
        $service->notifyDestroy($comic);
    }
}
