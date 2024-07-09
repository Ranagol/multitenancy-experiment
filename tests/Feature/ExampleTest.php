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
//        dd(Tenant::current());
        User::factory()->create(
            [
                'name' => 'very_new_user',
            ]
        );


            $response = $this->get('/');
//        $response = $this->get('/tenant1.localhost/');
//        $response = $this->get('/tenant1.localhost/andor');

        $response->assertStatus(200);
    }
}
