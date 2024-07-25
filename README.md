# What is this app?
Here I play with Spatie multitenancy package. The problem with this package is that it does not have a good documentation how 
to set up the TESTING part. Though they do have otherwise good docs. So, I had to experiment.
Warning: to understand all this, you must have a good understanding of Laravel, and good understanding of
multitenancy concept.

This is the only explanation from Spatie docs about testing setup:
https://spatie.be/docs/laravel-multitenancy/v3/advanced-usage/executing-code-for-tenants-and-landlords#content-testing-with-databasetransactions-for-tenant

Now, the way how I see it, there are at least two ways how to set up the testing in theory:
1.	We use simply 1 testing db, where we run all our tests. These tests are tenant tests. This is the easier setup version.
2.	We use test_landlord, test_tenant_1, test_tenant_2 dbs. This is very very hard to setup, because there is no full description about it on the net. Only bits and pieces. Nothing more.

So, in this experiment we use approach 2.


# How to set up the app?
sail down -v
sail up -d

Go to Phpmyadmin, and give permissions to the user 'sail' 

Migration for the landlord:

sail artisan migrate --path=database/migrations/landlord --database=landlord
•	The --database=landlord part of the command specifies the database connection that should be used when running the migrations. So, this is not the db name!!


Creating tenant(s) databases

sail artisan createTenants


Migrations for all tenants

sail artisan tenants:artisan "migrate --database=tenant"
•	This command will loop over the 'tenants' table in 'landlord' db. It will make each tenant the current one, and migrate the database.
•	The --database=tenant part of the command specifies the database connection that should be used when running the migrations. So, this is not the db name!!


Seed + migr versions for tenants

sail artisan tenants:artisan "db:seed --database=tenant"		migr + seed for all tenants

sail artisan tenants:artisan "migrate --database=tenant  --seed" --tenant=1
sail artisan tenants:artisan "db:seed --database=tenant" --tenant=2

# Databases

There are 6 databases in total:
1.	landlord - the main landlord db, containts thet tenants table for real tenants
2.  test_landlord - the test landlord db, contains the tenants table for test tenants
3. test_tenant_1 - as the name says: a test tenant
4. test_tenant_2 - as the name says: a test tenant
5.  tenant1 - the first real tenant
6. tenant2 - the second real tenant

# Tenant tables

## In the landlord db
````
id|name   |domain           |database|created_at|updated_at|
--+-------+-----------------+--------+----------+----------+
10|tenant1|tenant1.localhost|tenant1 |          |          |
11|tenant2|tenant2.localhost|tenant2 |          |          |
````


## In the test_landlord db
````
id|name         |domain           |database     |created_at|updated_at|
--+-------------+-----------------+-------------+----------+----------+
15|test_tenant_2|tenant2.localhost|test_tenant_2|          |          |
17|test_tenant_1|tenant1.localhost|test_tenant_1|          |          |
````

# etc/hosts setup
````
# Multitenancy-experiment 
127.0.0.1 tenant1.localhost
127.0.0.1 tenant2.localhost
127.0.0.1 tenant3.localhost
127.0.0.1 tenant1
127.0.0.1 tenant2
````


# Links

## tenant1
http://tenant1.localhost/
http://tenant1.localhost/andor
http://tenant1.localhost/telescope/requests

## tenant2
http://tenant2.localhost/
http://tenant2.localhost/andor
http://tenant2.localhost/telescope/requests

# How to set up the testing?

- See phpunit.xml
- See .env db setups
- See database.php, see all the connections: tenant, test_tenant, landlord, test_landlord
- See the ternary operators in  multitenancy.php
- Run the ExampleTest.php to check if alll the tests are working.

