<?php

namespace App\Interfaces;

use App\Models\Country;
use App\DTOs\Country as CountryDTO;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface CountryRepositoryInterface
{
    /**
     * @return Collection<Country>
     */
    public function getAllCountries(): Collection;

    /**
     * @throws  ModelNotFoundException
     */

    public function getCountryById(int $countryId): Country;

    public function deleteCountry(int $countryId): void;

    public function createCountry(CountryDTO $country): Country;

    /**
     * @throws  ModelNotFoundException
     */
    public function updateCountry(CountryDTO $country, int $countryId): void;
}
