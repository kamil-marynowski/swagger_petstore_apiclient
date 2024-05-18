<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Services\PetStoreApiService;

class PetApiRepository
{
    private PetStoreApiService $petStoreApiService;

    public function __construct(PetStoreApiService $petStoreApiService)
    {
        $this->petStoreApiService = $petStoreApiService;
    }

    public function getById(int $id): array
    {
        return $this->petStoreApiService->getPetById($id);
    }

    public function delete(int $id): array
    {
        return $this->petStoreApiService->delete($id);
    }
}
