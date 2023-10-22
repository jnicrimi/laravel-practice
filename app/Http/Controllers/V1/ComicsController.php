<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Errors\ComicError;
use App\Http\Errors\CommonError;
use App\Http\Requests\V1\Comic\DestroyFormRequest;
use App\Http\Requests\V1\Comic\IndexFormRequest;
use App\Http\Requests\V1\Comic\ShowFormRequest;
use App\Http\Requests\V1\Comic\StoreFormRequest;
use App\Http\Requests\V1\Comic\UpdateFormRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\V1\Comic\DestroyResource;
use App\Http\Resources\V1\Comic\IndexResource;
use App\Http\Resources\V1\Comic\ShowResource;
use App\Http\Resources\V1\Comic\StoreResource;
use App\Http\Resources\V1\Comic\UpdateResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Packages\UseCase\Comic\Destroy\ComicDestroyRequest;
use Packages\UseCase\Comic\Destroy\ComicDestroyUseCaseInterface;
use Packages\UseCase\Comic\Exception\ComicAlreadyExistsException;
use Packages\UseCase\Comic\Exception\ComicNotFoundException;
use Packages\UseCase\Comic\Exception\ComicUndeleteException;
use Packages\UseCase\Comic\Index\ComicIndexRequest;
use Packages\UseCase\Comic\Index\ComicIndexUseCaseInterface;
use Packages\UseCase\Comic\Show\ComicShowRequest;
use Packages\UseCase\Comic\Show\ComicShowUseCaseInterface;
use Packages\UseCase\Comic\Store\ComicStoreRequest;
use Packages\UseCase\Comic\Store\ComicStoreUseCaseInterface;
use Packages\UseCase\Comic\Update\ComicUpdateRequest;
use Packages\UseCase\Comic\Update\ComicUpdateUseCaseInterface;

class ComicsController extends Controller
{
    /**
     * @param ComicIndexUseCaseInterface $interactor
     * @param IndexFormRequest $formRequest
     *
     * @return IndexResource
     */
    public function index(
        ComicIndexUseCaseInterface $interactor,
        IndexFormRequest $formRequest
    ): IndexResource {
        $request = new ComicIndexRequest();
        $request->setKey($formRequest->input('key'))
            ->setName($formRequest->input('name'))
            ->setStatus($formRequest->input('status'));
        $response = $interactor->handle($request);

        return new IndexResource($response->build());
    }

    /**
     * @param ComicShowUseCaseInterface $interactor
     * @param ShowFormRequest $formRequest
     * @param mixed $comicId
     *
     * @return ShowResource|JsonResponse
     */
    public function show(
        ComicShowUseCaseInterface $interactor,
        ShowFormRequest $formRequest,
        mixed $comicId
    ): ShowResource|JsonResponse {
        try {
            $request = new ComicShowRequest();
            $request->setId((int) $comicId);
            $response = $interactor->handle($request);
        } catch (ComicNotFoundException $ex) {
            $errorResource = new ErrorResource([
                'code' => ComicError::ComicNotFound->code(),
                'message' => ComicError::ComicNotFound->message(),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            $errorResource = new ErrorResource([
                'code' => CommonError::InternalServerError->code(),
                'message' => CommonError::InternalServerError->message(),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new ShowResource($response->build());
    }

    /**
     * @param ComicStoreUseCaseInterface $interactor
     * @param StoreFormRequest $formRequest
     *
     * @return StoreResource|JsonResponse
     */
    public function store(
        ComicStoreUseCaseInterface $interactor,
        StoreFormRequest $formRequest
    ): StoreResource|JsonResponse {
        try {
            $request = new ComicStoreRequest();
            $request->setKey($formRequest->input('key'))
                ->setName($formRequest->input('name'))
                ->setStatus($formRequest->input('status'));
            $response = $interactor->handle($request);
        } catch (ComicAlreadyExistsException $ex) {
            $errorResource = new ErrorResource([
                'code' => ComicError::ComicAlreadyExists->code(),
                'message' => ComicError::ComicAlreadyExists->message(),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $ex) {
            $errorResource = new ErrorResource([
                'code' => CommonError::InternalServerError->code(),
                'message' => CommonError::InternalServerError->message(),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new StoreResource($response->build());
    }

    /**
     * @param ComicUpdateUseCaseInterface $interactor
     * @param UpdateFormRequest $formRequest
     * @param mixed $comicId
     *
     * @return UpdateResource|JsonResponse
     */
    public function update(
        ComicUpdateUseCaseInterface $interactor,
        UpdateFormRequest $formRequest,
        mixed $comicId
    ): UpdateResource|JsonResponse {
        try {
            $request = new ComicUpdateRequest();
            $request->setId((int) $comicId)
                ->setKey($formRequest->input('key'))
                ->setName($formRequest->input('name'))
                ->setStatus($formRequest->input('status'));
            $response = $interactor->handle($request);
        } catch (ComicNotFoundException $ex) {
            $errorResource = new ErrorResource([
                'code' => ComicError::ComicNotFound->code(),
                'message' => ComicError::ComicNotFound->message(),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_NOT_FOUND);
        } catch (ComicAlreadyExistsException $ex) {
            $errorResource = new ErrorResource([
                'code' => ComicError::ComicAlreadyExists->code(),
                'message' => ComicError::ComicAlreadyExists->message(),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $ex) {
            $errorResource = new ErrorResource([
                'code' => CommonError::InternalServerError->code(),
                'message' => CommonError::InternalServerError->message(),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new UpdateResource($response->build());
    }

    /**
     * @param ComicDestroyUseCaseInterface $interactor
     * @param DestroyFormRequest $formRequest
     * @param mixed $comicId
     *
     * @return DestroyResource
     */
    public function destroy(
        ComicDestroyUseCaseInterface $interactor,
        DestroyFormRequest $formRequest,
        mixed $comicId
    ): DestroyResource|JsonResponse {
        try {
            $request = new ComicDestroyRequest();
            $request->setId((int) $comicId);
            $response = $interactor->handle($request);
        } catch (ComicNotFoundException $ex) {
            $errorResource = new ErrorResource([
                'code' => ComicError::ComicNotFound->code(),
                'message' => ComicError::ComicNotFound->message(),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_NOT_FOUND);
        } catch (ComicUndeleteException $ex) {
            $errorResource = new ErrorResource([
                'code' => ComicError::ComicUndelete->code(),
                'message' => ComicError::ComicUndelete->message(),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $ex) {
            $errorResource = new ErrorResource([
                'code' => CommonError::InternalServerError->code(),
                'message' => CommonError::InternalServerError->message(),
                'errors' => [],
            ]);

            return $errorResource->response()->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new DestroyResource($response->build());
    }
}
