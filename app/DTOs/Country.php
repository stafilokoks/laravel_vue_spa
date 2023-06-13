<?php declare(strict_types=1);

namespace App\DTOs;

use App\Models\Country as CountryModel;

class Country
{
    public function __construct(
        public readonly string $name,
        public readonly string $capital,
    )
    {
    }

    /**
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return [
            'name'    => $this->name,
            'capital' => $this->capital,
        ];
    }
}
