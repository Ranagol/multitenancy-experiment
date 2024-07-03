<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Multitenancy\Models\Tenant;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public User $admin;
    public function run(): void
    {

        Tenant::checkCurrent()
            ? $this->runTenantSpecificSeeders()
            : $this->runLandlordSpecificSeeders();

    }

    public function runTenantSpecificSeeders(): void
    {
        $this->seedUsers();
        $this->seedRolesAndPermissions();

        $tenant = Tenant::first();
        $tenant->makeCurrent();
        $admin = User::where('name', 'admin')->first();//this is ok, we have the admin here
        $admin->assignRole('admin');//add role to user



//        dd(Auth::user());
//        dd($tenant, $admin);
//        Auth::login($admin);
//        try {
//            Auth::login($admin);
//        } catch (\Exception $e) {
//            dd($e);
//        }
//
//        try {
//            Auth::attempt([
//                'email' => 'admin@gmail.com',
//                'password' => 1234,
//            ]);
//            $request = request();
//            $request->session()->regenerate();
//        } catch (\Exception $e) {
//            dd($e);
//        }

//
//        dd(Auth::user());



//        Auth::login(User::where('name', 'user')->first());

    }

    public function runLandlordSpecificSeeders(): void
    {

    }

    private function getDbConnectionName(): string|null
    {
        return DB::connection()->getName();
    }

    private function seedRolesAndPermissions()
    {
        $adminRole = Role::create(['name' => 'admin']);

        $listPermission = Permission::create(['name' => 'list-users']);
        $adminRole->givePermissionTo($listPermission);

    }

    private function seedUsers()
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

        $this->admin = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 1234,
        ]);

        User::factory()->create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => 1234,
        ]);
    }
}
