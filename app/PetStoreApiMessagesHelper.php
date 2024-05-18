<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\HttpFoundation\Response;

class PetStoreApiMessagesHelper
{
    public const DELETE_PET = 'delete_pet';
    public const UPDATE_PET = 'update_pet';
    public const ADD_PET    = 'add_pet';
    public const GET_PET    = 'get_pet';

    private const MESSAGES = [
        self::DELETE_PET => [
            Response::HTTP_INTERNAL_SERVER_ERROR => 'An error occurred while trying to delete pet.',
            Response::HTTP_NOT_FOUND             => 'Pet not found.',
            Response::HTTP_BAD_REQUEST           => 'An error occurred while trying to delete pet.',
            Response::HTTP_OK                    => 'Pet deleted',
        ],
        self::UPDATE_PET => [
            Response::HTTP_INTERNAL_SERVER_ERROR => 'An error occurred while trying to update pet.',
            Response::HTTP_NOT_FOUND             => 'Pet not found.',
            Response::HTTP_BAD_REQUEST           => 'An error occurred while trying to update pet.',
            Response::HTTP_METHOD_NOT_ALLOWED    => 'An error occurred while trying to update pet.',
            Response::HTTP_OK                    => 'Pet updated',
        ],
        self::ADD_PET => [
            Response::HTTP_INTERNAL_SERVER_ERROR => 'An error occurred while trying to add pet.',
            Response::HTTP_METHOD_NOT_ALLOWED    => 'An error occurred while trying to add pet.',
            Response::HTTP_OK                    => 'Pet added',
        ],
        self::GET_PET => [
            Response::HTTP_INTERNAL_SERVER_ERROR => 'An error occurred while trying to get pet.',
            Response::HTTP_NOT_FOUND             => 'Pet not found.',
            Response::HTTP_BAD_REQUEST           => 'An error occurred while trying to get pet.',
            Response::HTTP_OK                    => 'Pet found',
        ],
        'default' => [
            Response::HTTP_INTERNAL_SERVER_ERROR => 'An error occurred.',
        ],
    ];

    public static function getMessage(
        string $action = 'default',
        int $code = Response::HTTP_INTERNAL_SERVER_ERROR
    ): string
    {
        return self::MESSAGES[$action][$code] ?? self::MESSAGES['default'][$code];
    }
}
