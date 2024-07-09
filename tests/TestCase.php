<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use Spatie\Multitenancy\Concerns\UsesMultitenancyConfig;
use Spatie\Multitenancy\Events\MadeTenantCurrentEvent;
use Spatie\Multitenancy\Models\Tenant;

abstract class TestCase extends BaseTestCase
{
    use DatabaseTransactions;//this is is an alternative to RefreshDatabase
    use UsesMultitenancyConfig;

    protected function connectionsToTransact()
    {
        return [
            $this->landlordDatabaseConnectionName(),
            $this->tenantDatabaseConnectionName(),
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        //Here we register an event listener
        Event::listen(MadeTenantCurrentEvent::class, function () {
//            $this->beginDatabaseTransaction();//todo commented out, so I can see in which db is the user created. But this must be uncommented later!
        });

//        Tenant::first()->makeCurrent();
        $testingTenant = Tenant::where('name', 'testing')->first();
        $testingTenant->makeCurrent();//Here we trigger the event
    }

}
