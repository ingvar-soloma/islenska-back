<?php

namespace App\Http\Services;

use App\Interfaces\Service;
use Illuminate\Database\Eloquent\Model;

abstract class BaseService implements Service
{

    public function store(array $validated): ?Model
    {
        return $this->repository->create($validated);
    }

    public function getAllData(array $validated, array $with): array
    {
        return $this->repository->getAll($validated, $with)->toArray();
    }

    /**
     * @return Model|array
     */
    public function show(int $id)
    {
        return $this->repository->show($id);
    }

    /**
     * @throws \Exception
     */
    public function update(array $validated, int $id): ?Model
    {
        $this->repository->update($id, $validated);
        return $this->repository->show($id);
    }

    /**
     * @throws \Exception
     */
    public function destroy(int $id): array
    {
        $result = $this->repository->delete($id);
        return ['result' => $result];
    }

    public function get(string $fieldName, int $id, mixed $default = null): mixed
    {
        return $id > 0 ? $this->repository::show($id, [$fieldName])->$fieldName : $default;
    }
}
