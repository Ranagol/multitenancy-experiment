We stopped on main branch. If we will continue with this, simply just to do the main branch and that is that.

How to set up the app?
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