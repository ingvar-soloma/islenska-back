<?php

namespace App\Http\Repositories;

use App\Interfaces\ModelRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class BaseRepository implements ModelRepository
{
    protected static Model $model;

    public function __construct(Model $model)
    {
        self::$model = $model;
    }

    public static function create(array $validated): Model
    {
        return self::$model::create($validated);
    }

    public static function getAll(array $params, array $with = [], array $fields = ['*']): Collection
    {
        $query = self::$model::select($fields)->with($with);

        foreach ($params as $key => $value) {
            if (is_array($value)) {
                $query->whereIn($key, $value);
            } else {
                $query->where($key, $value);
            }
        }

        return $query->get();
    }

    public static function show(int $id): Model
    {
        return self::$model::findOrFail($id);
    }

    public static function update(int $id, array $validated): bool
    {
        $modelInstance = self::show($id);
        return $modelInstance->update($validated);
    }

    public static function delete(int $id): ?bool
    {
        $modelInstance = self::show($id);
        return $modelInstance->delete();
    }
}
