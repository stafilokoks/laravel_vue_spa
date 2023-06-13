<?php declare(strict_types=1);

namespace App\Services;

use App\Http\Resources\CountryResource;
use App\Models\Country;
use App\DTOs\Country as CountryDTO;
use App\Interfaces\CountryRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CountryService
{
    public function __construct(
        private readonly CountryRepositoryInterface $countryRepository
    )
    {
    }

    public function getAllCountries(): ResourceCollection
    {
        return CountryResource::collection($this->countryRepository->getAllCountries());
    }

    public function getCountryById(int $countryId): Country
    {
        return $this->countryRepository->getCountryById($countryId);
    }

    public function deleteCountry(int $countryId): void
    {
        $this->countryRepository->deleteCountry($countryId);
    }

    public function createCountry(CountryDTO $country): Country
    {
        return $this->countryRepository->createCountry($country);
    }

    /**
     * @throws  ModelNotFoundException
     */
    public function updateCountry(CountryDTO $country, int $countryId): void
    {
        $this->countryRepository->updateCountry($country, $countryId);
    }


}
