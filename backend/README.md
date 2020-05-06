## Backend(Zhetenov Ralan)

### Installation

Local: 

    $ composer update
    $ cp .evn.example .env
    $ php artisan key:generate
    $ npm install
    $ npm run dev
    $ php artisan serve

Docker: 
    
    $ docker-compose up -d
    $ docker-compsose exec app bash
    $ composer update
    $ cp .evn.example .env
    $ php artisan key:generate
    $ npm install
    $ npm run dev
    $ php artisan serve

Also, you need up database, and build config.

### TODO list

```
 * [x] Authorization
 * [x] Registration
 * [X] Data storing
 * [X] Statistics of all data
 * [X] CRM targeting
 * [X] Download result
 * [X] Mailing
```


 