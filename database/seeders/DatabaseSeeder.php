<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Multitenancy\Models\Tenant;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        {
            Tenant::checkCurrent()
                ? $this->runTenantSpecificSeeders()
                : $this->runLandlordSpecificSeeders();
        }
    }

    public function runTenantSpecificSeeders(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }

    public function runLandlordSpecificSeeders(): void
    {

    }
}
