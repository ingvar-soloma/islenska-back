<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\BaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class BaseApiController extends Controller
{
    protected BaseService $service;
    abstract protected function getService(): BaseService;
    abstract protected function getRequestClass(string $method): string;
    abstract protected function getResourceClass(): string;

    protected function getRelations(string $method): array
    {
        return match ($method) {
            'update' => [],
            'store' => [],
            'index' => [],
            'show' => [],
            default => throw new \InvalidArgumentException("Unknown method for request class resolution"),
        };
    }

    // Implement common CRUD operations using abstract methods
    final public function store(Request $request): JsonResponse
    {
        $requestClass = $this->getRequestClass(__FUNCTION__);
        $validated = $request->validate(app($requestClass)->rules());
        $with = $this->getRelations(__FUNCTION__);

        $this->service = $this->getService();
        $model = $this->service->store($validated);
        $model->load($with);

        $resourceClass = $this->getResourceClass();
        return response()->json(new $resourceClass($model));
    }

    final public function index(Request $request): JsonResponse
    {
        $requestClass = $this->getRequestClass(__FUNCTION__);
        $validated = $request->validate(app($requestClass)->rules());
        $with = $this->getRelations(__FUNCTION__);

        $this->service = $this->getService();
        $data = $this->service->getAllData($validated, $with);

        $resourceClass = $this->getResourceClass();
        return response()->json($resourceClass::collection($data));
    }

    final public function show(int $id): JsonResponse
    {
        $with = $this->getRelations(__FUNCTION__);

        $this->service = $this->getService();
        $model = $this->service->show($id);
        $model->load($with);

        $resourceClass = $this->getResourceClass();
        return response()->json(new $resourceClass($model));
    }

    /**
     * @throws \Exception
     */
    final public function update(Request $request, int $id): JsonResponse
    {
        $requestClass = $this->getRequestClass(__FUNCTION__);
        $validated = $request->validate(app($requestClass)->rules());
        $with = $this->getRelations(__FUNCTION__);

        $this->service = $this->getService();
        $model = $this->service->update($validated, $id);
        $model->load($with);

        $resourceClass = $this->getResourceClass();
        return response()->json(new $resourceClass($model));
    }

    /**
     * @throws \Exception
     */
    final public function destroy(int $id): JsonResponse
    {
        $this->service = $this->getService();
        $data = $this->service->destroy($id);

        return response()->json(['success' => $data]);
    }
}
