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
    use DatabaseTransactions;//this is is a faster alternative to RefreshDatabase
    use UsesMultitenancyConfig;

    /**
     * This here is needed to the beginDatabaseTransaction() method to work
     */
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

        //Here we register an event listener, that listens for the ->makeCurrent() method
        Event::listen(MadeTenantCurrentEvent::class, function () {
            //todo: commented out, so I can see in which db is the user created. But this must be uncommented later!
            $this->beginDatabaseTransaction();
        });

        // I want to test happen in this tenant (which is my testing tenant)
        $testingTenant = Tenant::where('name', 'testing')->first();
        $testingTenant->makeCurrent();//Here we trigger the event
    }
}
