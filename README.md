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

1. Insert API : METHOD post -> /api/account ->  require bearer access_token -> $_POST data must send encrypt id and data to insert

2. Update API : METHOD post -> /account/{id} ->  require bearer access_token -> $_POST data must send encrypt id and data to update

3. Delete API : METHOD delete -> /account/{id} ->  require bearer access_token -> $_POST data must send encrypt id

4. List Data API : METHOD get -> /api/accounts ->  require bearer access_token -> $_GET data can send [page] and [filter]

5. Single Account API : METHOD get -> /account/{id} ->  require bearer access_token -> $_POST data must send encrypt id and data to insert

5. Login API : METHOD post -> /api/auth/login -> require username and password

6. Logout API : METHOD post -> /api/auth/logout ->  require bearer access_token

7. Me Api : METHOD post -> /api/auth/me ->  require bearer access_token

Example File In postman can download and import to postman file