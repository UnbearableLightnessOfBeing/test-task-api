
## API test task

A simple API app that implements api end-points for user data manipulation.
It also has an administration panel built with Backpack.

Built with:

- [Laravel](https://laravel.com/).
- [Backpack](https://backpackforlaravel.com/).
- MySQL / PostgreSQL.


## How to get it running

1) Install dependencies:

``` bash
composer install
```

2) Generate a new key:

``` bash
php artisan key:generate
```

3) Put required database credentials in .env file (use .env.example as an example)

4) Create users and admins tables in your database with migration:

``` bash
php artisan migrate
```

5) If you want you can populate your users table with random data.
The next command will generate 20 users and put it in the users table:

``` bash
php artisan db:seed
```

5) Run development server:

``` bash
php artisan serve
```

## API methods: 

post - .../api/User-{user id}
-
Required: "email" "userName" Optional: "name"  =>  
Creates a new user

get - .../api/User-{user id}
-
Gets user data

put - .../api/User-{user id}
-
Required: "userName" "name"  =>  
Edits user data

patch - .../api/User-{user id}
-
Optional: "name" "userName"  =>  
Edits user data

delete - .../api/User-{user id}
-
Deletes a user

Admin panel access - .../admin
-
