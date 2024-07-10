<?php

namespace Tests\Feature;

 use App\Models\User;
 use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Multitenancy\Models\Tenant;
use Tests\TestCase;

class ExampleTest extends TestCase
{

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        User::factory()->create(
            [
                'name' => 'very_new_user',
            ]
        );

        /**
         * We send request to regular, simple, non-tenant routes. Because
         * we already set up who is the tenant in the TestCase.php.
         * So, do not send request to 'tenant1.localhost/'. Send requests
         * to '/'.
         */
//        $response = $this->get('/');
        $response = $this->get('/andor');

        $response->assertStatus(200);
    }
}
