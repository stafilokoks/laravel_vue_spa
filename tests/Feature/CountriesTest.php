<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Country;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CountriesTest extends TestCase
{
    use DatabaseMigrations;

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_list_successful(): void
    {
        Country::factory()->count(10)->create();

        $response = $this->get(
            '/api/countries',
            $this->generateHeaders()
        );

        $response->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data'=>[
                        0 => [
                            'id',
                            'name',
                            'capital',
                        ]
                    ]
                ]);
    }

    public function test_list_without_authentication_unsuccessful(): void
    {
        Country::factory()->count(10)->create();

        $response = $this->get(
            '/api/countries',
            // Headers without Authorization token
            [
                'Accept'=>'application/json',
            ]
        );

        $response->assertStatus(401);
    }

    public function test_get_country_successful(): void
    {
        Country::factory()->count(10)->create();

        $response = $this->get(
            '/api/countries/1',
            $this->generateHeaders()
        );

        $response->assertStatus(200)
            ->assertJsonStructure(
                [
                    'id',
                    'name',
                    'capital',
                ]);
    }

    public function test_get_country_with_wrong_id_unsuccessful(): void
    {
        Country::factory()->count(10)->create();

        $response = $this->get(
            '/api/countries/555',
            // Headers without Authorization token
            [
                'Accept'=>'application/json',
            ]
        );

        $response->assertStatus(401);
    }

    public function test_create_country_successful(): void
    {
        $response = $this->post(
            '/api/countries',
            [
                'name'=>'Uruguay',
                'capital'=>'Montevideo',
            ],
            $this->generateHeaders());

        $response->assertStatus(201)
            ->assertJsonStructure(
                [
                    'id',
                    'name',
                    'capital',
                ])
            ->assertJsonFragment(['name'=>'Uruguay']);
    }

    public function test_create_country_validation_error_unsuccessful(): void
    {
        $response = $this->post(
            '/api/countries',
            [
                'nameTest'=>'Uruguay',
                'capital222'=>'Montevideo',
            ],
            $this->generateHeaders()
        );

        $response->assertStatus(422);
    }

    public function test_update_country_successful(): void
    {
        Country::factory()->count(10)->create();

        $headers = $this->generateHeaders();

        $response = $this->put(
            '/api/countries/1',
            [
                'name'=>'Uruguay',
                'capital'=>'Montevideo',
            ],
            $headers
        );

        $response->assertStatus(200);

        $response = $this->get(
            '/api/countries/1',
            $headers
        );

        $response->assertStatus(200)
            ->assertJsonFragment(['name'=>'Uruguay']);
    }

    public function test_update_country_validation_error_unsuccessful(): void
    {
        Country::factory()->count(10)->create();

        $response = $this->put(
            '/api/countries/1',
            [
                'nameTest'=>'Uruguay',
                'capital222'=>'Montevideo',
            ],
            $this->generateHeaders()
        );

        $response->assertStatus(422);
    }

    public function test_delete_country_successful(): void
    {
        Country::factory()->count(10)->create();

        $response = $this->delete(
            '/api/countries/1',
            [],
            $this->generateHeaders()
        );

        $response->assertStatus(204);
    }

    private function getAuthToken(): string
    {
        $user = User::factory()->create();
        return $user->createToken('API_TOKEN')->plainTextToken;
    }

    /**
     * @return array<string, string>
     */
    private function generateHeaders(): array
    {
        return [
            'Accept'=>'application/json',
            'Authorization'=>'Bearer ' . $this->getAuthToken()
        ];
    }
}
