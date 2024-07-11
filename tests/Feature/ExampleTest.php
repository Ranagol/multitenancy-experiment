<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Multitenancy\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Tenant::updateOrInsert(
            [
                'name' => 'test_tenant_1',
                'domain' => 'tenant1.localhost',
                'database' => 'test_tenant_1'
            ]
        );
        $tenant = Tenant::where('name', 'test_tenant_1')->firstOrFail();
//        dd($tenant);
        $tenant->makeCurrent();
    }

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {

//        User::factory()->create(
//            [
//                'name' => 'very_new_user',
//            ]
//        );

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
