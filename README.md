require php version > 8.0

How to run

1. copy .env.example to .env for edit environment (DB)

2. run composer install on git bash or any terminal (Install composer to machine first)

3. Database has 2 functional

3.1. use migrate

    3.1.1. create database on dbms (such as phpmyadmin) name exe_test or any name in .env DB_DATABASE

    3.1.2. change database usename password in .env

    3.1.3. run : "php artisan migrate" on git bash or any terminal

3.2. import database 

    From folder DB to dbms by create database name like .env DB_DATABASE

4. Run 

run php artisan serve for watch result

**if keytgen wrong let create new

**if dont have jwtsecret run artisan jwt:secret

API Description

1. Insert API 

2. Update API 

3. Delete API

4. List Data API

5. Login API 

6. Logout API

7. Me Api