<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class PetRepository
{
    private const PETS_FILE = 'pets.json';

    private Filesystem $storage;

    public function __construct()
    {
        $this->storage = Storage::disk('local');
    }

    /**
     * Returns all cached pets from pets.json
     *
     * @return array
     */
    public function getAll(): array
    {
        return json_decode($this->storage->get(self::PETS_FILE), true) ?? [];
    }

    /**
     * Cache pet data in pets.json
     *
     * @param array $data
     * @return void
     */
    public function save(array $data): void
    {
        $pets = [];
        if ($this->storage->exists('pets.json')) {
            $pets = json_decode($this->storage->get('pets.json'), true);
        }

        $pets[$data['id']] = $data;

        $this->storage->put('pets.json', json_encode($pets));
    }

    /**
     * Deletes cached pet data from pets.json
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $pets = $this->getAll();

        if (array_key_exists($id, $pets)) {
            unset($pets[$id]);
        }

        $this->storage->put(self::PETS_FILE, json_encode($pets));
    }
}
