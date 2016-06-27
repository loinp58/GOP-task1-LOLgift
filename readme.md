# Demo send gift LOL 

### Introduction
This app is virtual system to send gift game LOL to user after they choose gift. When user access to page, they must login to go to main page. If they haven't choosen gift before, show them the page with gifts, they choose gift and wait for server send gift to their account. If they have choosen gift, system don't show the main page and have message to notify they must wait or check account.

### Installation
This installation is for Linux OS. For Window, some steps are different.

To run this app, your server must have Apache, Mysql, PHP >= 5.5.9, Composer and Redis.
```sh
$ sudo apt-get update
$ sudo apt-get install apache2
$ sudo apt-get install mysql-server php5-mysql
$ sudo apt-get install php5 libapache2-mod-php5 php5-mcrypt
$ curl -sS https://getcomposer.org/installer | php
$ sudo apt-get install redis-server
```

Clone this repo:
```sh
$ git clone https://github.com/loinp58/GOP-task1-LOLgift.git
```

After git clone successfully, run command to download packages

```sh
$ cd GOP-task1-LOLgift
$ composer install
```

Copy file ```.env.example``` and rename to ```.env``` and run command to generate key for this app

```sh
$ cp .env.example .env
$ php artisan key:generate
```
Open editor file .env to config ```cache``` for using redis:

```sh
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_DRIVER=redis
```

Change ```DB_DATABASE```, ```DB_USERNAME```, ```DB_PASSWORD``` is your database name, username and password to login ```mysql``` server.

To create table for database, run command and after that, run server

```sh
$ php artisan migrate
$ php artisan serve
Laravel development server started on http://localhost:8000/
```
