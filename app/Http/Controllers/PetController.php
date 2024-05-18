<?php
//5h
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\PetStoreRequest;
use App\Http\Requests\PetUpdateRequest;
use App\Repositories\PetApiRepository;
use App\Repositories\PetRepository;
use App\Services\PetStoreApiService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class PetController extends Controller
{
    private PetStoreApiService $petStoreApiService;

    private PetApiRepository $petApiRepository;

    private PetRepository $petRepository;

    /**
     * @param PetStoreApiService $petStoreApiService
     * @param PetApiRepository $petApiRepository
     * @param PetRepository $petRepository
     */
    public function __construct(
        PetStoreApiService $petStoreApiService,
        PetApiRepository $petApiRepository,
        PetRepository $petRepository,
    )
    {
        $this->petStoreApiService = $petStoreApiService;
        $this->petApiRepository   = $petApiRepository;
        $this->petRepository      = $petRepository;
    }

    /**
     * Returns pets list view.
     *
     * @return View
     */
    public function index(): View
    {
        $pets = $this->petRepository->getAll();

        return view('pets.index', ['pets' => $pets]);
    }

    /**
     * Returns new pet create form view.
     *
     * @return View
     */
    public function create(): View
    {
        return view('pets.create');
    }

    /**
     * Stores new pet on https://petstore.swagger.io & cache it in pets.json
     *
     * @param PetStoreRequest $request
     * @return RedirectResponse
     */
    public function store(PetStoreRequest $request): RedirectResponse
    {
        $payload  = $this->petStoreApiService->prepareStorePayload($request->validated());
        $response = $this->petStoreApiService->addNewPetToTheStore($payload);

        if ($response['code'] !== Response::HTTP_OK) {
            return redirect()->route('pets.create')->with('error', $response['msg']);
        }

        $this->petRepository->save($response['data']);

        return redirect()->route('pets.index')->with('success', $response['msg']);
    }

    /**
     * Returns pet edit form view.
     *
     * @param int $id
     * @return RedirectResponse|View
     */
    public function edit(int $id): RedirectResponse|View
    {
        $response = $this->petApiRepository->getById($id);

        if (Response::HTTP_OK !== $response['code']) {
            if (Response::HTTP_NOT_FOUND === $response['code']) {
                $this->petRepository->delete($id);
            }

            return redirect()->route('pets.index')->with('error', $response['msg']);
        }

        return view('pets.edit', ['pet' => $response['data']]);
    }

    /**
     * Updates pet data on https://petstore.swagger.io and cached in pets.json
     *
     * @param PetUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(PetUpdateRequest $request, int $id): RedirectResponse
    {
        $payload  = $this->petStoreApiService->prepareUpdatePayload($request->validated());
        $response = $this->petStoreApiService->updateAnExistingPet($payload);

        if (Response::HTTP_OK !== $response['code']) {
            return redirect()->route('pets.edit', ['id' => $id])->with('error', $response['msg']);
        }

        $this->petRepository->save($response['data']);

        return redirect()->route('pets.index')->with('success', $response['msg']);
    }

    /**
     * Returns pet details view.
     *
     * @param int $id
     * @return RedirectResponse|View
     */
    public function show(int $id): RedirectResponse|View
    {
        $response = $this->petApiRepository->getById($id);

        if (Response::HTTP_OK !== $response['code']) {

            if (Response::HTTP_NOT_FOUND === $response['code']) {
                $this->petRepository->delete($id);
            }

            return redirect()->route('pets.index')->with('error', $response['msg']);
        }

        return view('pets.show', ['pet' => $response['data']]);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $response = $this->petApiRepository->delete($id);

        if (Response::HTTP_OK !== $response['code']) {
            return redirect()->route('pets.index')->with('error', $response['msg']);
        }

        $this->petRepository->delete($id);

        return redirect()->route('pets.index')->with('success', $response['msg']);
    }

}
