<?php declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\CountryRepositoryInterface;
use App\Models\Country;
use App\DTOs\Country as CountryDTO;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

// Usually query builder should be used for the more complex requests.
class CountryRepository implements CountryRepositoryInterface
{
    /**
     * @return Collection<Country>
     */
    public function getAllCountries(): Collection
    {
        return Country::all();
    }

    /**
     * @throws  ModelNotFoundException
     */
    public function getCountryById(int $countryId): Country
    {
        return Country::findOrFail($countryId);
    }

    public function deleteCountry($countryId): void
    {
        Country::destroy($countryId);
    }

    public function createCountry(CountryDTO $country): Country
    {
        return Country::create($country->toArray());
    }

    /**
     * @throws  ModelNotFoundException
     */
    public function updateCountry(CountryDTO $country, int $countryId): void
    {
        $country = Country::findOrFail($countryId)->update($country->toArray());
    }
}
