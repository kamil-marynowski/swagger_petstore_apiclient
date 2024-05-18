<?php

declare(strict_types=1);

namespace App\Services;

use App\PetStoreApiMessagesHelper;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class PetStoreApiService
{
    private const BASE_URI = 'https://petstore.swagger.io/v2/';

    private Client $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => self::BASE_URI, 'verify' => false]);
    }

    public function prepareStorePayload(array $data): array
    {
        return [
            'category' => [
                'id' => $data['category_id'],
                'name' => $data['category_name'],
            ],
            'name' => $data['name'],
            'photoUrls' => $data['photo_urls'] ?? [],
            'tags' => $data['tags'] ?? [],
            'status' => $data['status'],
        ];
    }

    public function prepareUpdatePayload(array $data): array
    {
        return [
            'id' => $data['id'],
            'category' => [
                'id' => $data['category_id'],
                'name' => $data['category_name'],
            ],
            'name' => $data['name'],
            'photoUrls' => $data['photo_urls'] ?? [],
            'tags' => $data['tags'] ?? [],
            'status' => $data['status'],
        ];
    }

    /**
     * @param array $payload
     * @return array
     */
    public function addNewPetToTheStore(array $payload): array
    {
        $action = PetStoreApiMessagesHelper::ADD_PET;

        try {
            $response = $this->client->post('pet', ['json' => $payload]);
        } catch (GuzzleException $e) {
            return $this->handleException($e, $action);
        }

        return $this->handleResponse($response, $action);
    }

    public function updateAnExistingPet(array $payload): array
    {
        $action = PetStoreApiMessagesHelper::UPDATE_PET;

        try {
            $response = $this->client->put('pet', ['json' => $payload]);
        } catch (GuzzleException $e) {
            return $this->handleException($e, $action);
        }

        return $this->handleResponse($response, $action);
    }

    public function getPetById(int $id): array
    {
        $action = PetStoreApiMessagesHelper::GET_PET;

        try {
            $response = $this->client->get('pet/' . $id);
        } catch (GuzzleException $e) {
            return $this->handleException($e, $action);
        }

        return $this->handleResponse($response, $action);
    }

    public function delete(int $id): array
    {
        $action = PetStoreApiMessagesHelper::DELETE_PET;

        try {
            $response = $this->client->delete('pet/' . $id);
        } catch (GuzzleException $e) {
            return $this->handleException($e, $action);
        }

        return $this->handleResponse($response, $action);
    }

    /**
     * @param int $code
     * @param string $msg
     * @param array $data
     * @return array
     */
    private function response(int $code, string $msg, array $data = []): array
    {
        return [
            'code' => $code,
            'msg'  => $msg,
            'data' => $data,
        ];
    }

    /**
     * @param GuzzleException $e
     * @param string $action
     * @return array
     */
    private function handleException(GuzzleException $e, string $action): array
    {
        $code = $e->getCode();

        return $this->response(code: $code, msg: PetStoreApiMessagesHelper::getMessage(action: $action, code: $code));
    }

    /**
     * @param ResponseInterface $response
     * @param string $action
     * @return array
     */
    private function handleResponse(ResponseInterface $response, string $action): array
    {
        return $this->response(
            code: $response->getStatusCode(),
            msg: PetStoreApiMessagesHelper::getMessage(action: $action, code: $response->getStatusCode()),
            data: $this->getResponseBodyContent($response),
        );
    }

    /**
     * @param ResponseInterface $response
     * @return mixed
     */
    private function getResponseBodyContent(ResponseInterface $response): mixed
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}
