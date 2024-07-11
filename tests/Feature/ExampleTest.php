<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Multitenancy\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
//    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // Creating tenants in test_landlord database
        Tenant::updateOrInsert(
            [
                'name' => 'test_tenant_1',
                'domain' => 'tenant1.localhost',
                'database' => 'test_tenant_1'
            ],

        );

        Tenant::updateOrInsert(
            [
                'name' => 'test_tenant_2',
                'domain' => 'tenant2.localhost',
                'database' => 'test_tenant_2'
            ],
        );

        // Migrating for test_tenant_1 and test_tenant_2
        Artisan::call('tenants:artisan "migrate --database=test_tenant"');//database here means connection

    }

    /**
     * A basic test example.
     */
    public function test_in_test_tenant_1(): void
    {

        $tenant = Tenant::where('name', 'test_tenant_1')->firstOrFail();
//        dd($tenant);
        $tenant->makeCurrent();

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

    public function test_in_test_tenant_2(): void
    {

        $tenant = Tenant::where('name', 'test_tenant_2')->firstOrFail();
//        dd($tenant);
        $tenant->makeCurrent();

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
