# Laravel 8 Starter

WEB FullStack-SPA Project base on [Laravel Jetstream](https://jetstream.laravel.com/2.x/introduction.html), [TailwindCss](https://tailwindcss.com/), & [Alpinejs](https://github.com/alpinejs/alpine/)

<p>
    <img alt="laravel" height="30px" width="35px" src="https://raw.githubusercontent.com/adiyansahcode/adiyansahcode/main/assets/laravel-icon-new.svg" />
    &nbsp;
    <img alt="jetstream" height="30px" width="35px" src="https://raw.githubusercontent.com/adiyansahcode/adiyansahcode/main/assets/laravel-jetstream-icon.svg" />
    &nbsp;
    <img alt="livewire" height="30px" width="35px" src="https://raw.githubusercontent.com/adiyansahcode/adiyansahcode/main/assets/laravel-livewire-icon.svg" />
    &nbsp;
    <img alt="tailwindcss" height="30px" width="35px" src="https://raw.githubusercontent.com/adiyansahcode/adiyansahcode/main/assets/tailwindcss-icon.svg" />
    &nbsp;
    <img alt="tailwindcss" height="30px" width="35px" src="https://raw.githubusercontent.com/adiyansahcode/adiyansahcode/main/assets/alpinejs-icon.svg" />
    &nbsp;
</a>

## Function List

* [x] User Migrate and Seeder
* [x] User Register & Email Verification
* [x] User Login
* [x] User Login With Two Factor Authentication
* [x] User Forgot Password
* [x] User Setting Profile
* [x] User Setting Two-factor Authentication

## Installation

* clone this project
* Create .env file `cp .env.example .env`
* edit config database and mail in .env file
* Install composer package `composer install`
* Install npm package `npm install`
* Run laravel Mix `npm run dev`
* clean cache, create key and create storage
```
composer dumpautoload -o
php artisan key:generate
php artisan storage:link
```
* run Migration and Seeder `php artisan migrate:fresh --seed`
* run server `php artisan serve --port=8080`
* done, just try run your project in browser to `http://127.0.0.1:8080`
* **nginx server is recommended**
* default user login
```
email : admin@email.com
password : admin
```
