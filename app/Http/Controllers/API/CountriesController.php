<?php

namespace App\Http\Controllers\API;

use App\DTOs\Country;
use App\Http\Controllers\Controller;
use App\Services\CountryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Illuminate\Validation\ValidationException;

class CountriesController extends Controller
{
    public function __construct(
        private readonly CountryService $countryService
    )
    {
    }

    public function index(): JsonResponse
    {
        try {
            $response = response()->json(
                [
                    'data' => $this->countryService->getAllCountries()
                ],
                Response::HTTP_OK
            );
        } catch (Throwable $e) {
            $response = $this->responseError($e->getMessage());
        }

        return $response;
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validateCountry($request);

        return $this->countryService->createCountry(
            new Country(
                $request->name,
                $request->capital
            )
        );
    }

    public function show(Request $request, int $id)
    {
        $this->validate($request, ['id' => 'numeric|gt:0']);

        try {
            return $this->countryService->getCountryById($id);
        } catch (ModelNotFoundException $e) {
            return $this->responseError("Country with the ID $id was not found", Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @throws ValidationException
     */
    public function update(Request $request, int $id): Response
    {
        $this->validateCountry($request, $id);

        try {
            $this->countryService->updateCountry(
                new Country(
                    $request->name,
                    $request->capital
                ),
                $id
            );
        } catch (ModelNotFoundException $e) {
            return $this->responseError("Country with the ID $id was not found", Response::HTTP_NOT_FOUND);
        }

        return response()->json(
            null,
            Response::HTTP_OK
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->countryService->deleteCountry($id);

        // Regardless if the ID was wrong or deleting was successfully, there is "no content"
        return response()->json(
            null,
            Response::HTTP_NO_CONTENT
        );
    }

    private function responseError(
        string $message,
        int $responseCode = Response::HTTP_INTERNAL_SERVER_ERROR
    ): JsonResponse
    {
        return response()->json(
            [
                'message' => $message,
            ],
            $responseCode
        );
    }

    /**
     * @throws ValidationException
     */
    private function validateCountry(Request $request, string $existedCountryId = ''): void
    {
        $this->validate(
            $request,
            [
                'name' => 'required|string|unique:countries,name' . $existedCountryId,
                'capital' => 'required|string'
            ]
        );
    }
}
