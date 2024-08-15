<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface Service
{
    public function store(array $validated): ?Model;
    public function getAllData(array $validated, array $with);

    /**
     * @return Model|array
     */
    public function show(int $id);
    public function update(array $validated, int $id): Model;
    public function destroy(int $id): array;
}
