<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Multitenancy\Models\Tenant;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Tenant::checkCurrent()
            ? $this->runTenantSpecificSeeders()
            : $this->runLandlordSpecificSeeders();

    }

    public function runTenantSpecificSeeders(): void
    {

        /**
         *  This user will be called tenant1 or tenant2, and its purpose is to
         *  able to prove that the on url tenant.localhost we se the tenant 1
         *  database data, aka tenant 1 or tenant2.
         */
        User::factory()->create([
            'name' => Tenant::current()->name,
            'email' => $this->getDbConnectionName() .  '@example.com',
        ]);

        User::factory()->create([
            'name ' => 'admin',
        ]);

        User::factory()->create([
            'name ' => 'userWithoutRoles',
        ]);
    }

    public function runLandlordSpecificSeeders(): void
    {

    }

    private function getDbConnectionName(): string|null
    {
        return DB::connection()->getName();
    }
}
