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

    public function getAllData(array $validated, array $with)
    {
        return $this->repository->getAll($validated, $with);
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
    public function update(array $validated, Model|int $id): ?Model
    {
        return $this->repository->update($id, $validated);
    }

    /**
     * @throws \Exception
     */
    public function destroy(Model|int $id): array
    {
        $result = $this->repository->delete($id);
        return ['result' => $result];
    }

    public function get(string $fieldName, int $id, mixed $default = null): mixed
    {
        return $id > 0 ? $this->repository::show($id, [$fieldName])->$fieldName : $default;
    }

    public function getModel()
    {
        return $this->repository->getModel();
    }
}
