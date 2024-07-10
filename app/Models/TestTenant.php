<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Multitenancy\Models\Tenant;

class TestTenant extends Tenant
{
    use HasFactory;//todo UsesTenantConnection??????????????????

    protected  $connection = 'tenant';

    protected  $table = 'test_tenants';


}
