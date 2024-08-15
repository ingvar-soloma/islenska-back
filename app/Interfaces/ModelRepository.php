<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface ModelRepository
{
    public static function create(array $validated): Model;
    public static function getAll(array $params, array $with = []): Collection;
    public static function show(int $id): Model;
    public static function update(int $id, array $validated): bool;
    public static function delete(int $id): ?bool;

}
