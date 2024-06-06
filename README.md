<p style="margin: 50px 0;">
 <img width="300px" src="resources/assets/images/logo.png" alt="FakeStoreLogo"/>
</p>

## About

SPA Online FakeStore on Laravel and Vue where you can order products from home. With the ability for the admin to track
statistics on sales and top-selling products. Frequently requested data is cached using Redis. 
CRUD for products, orders.

## Stack

Frontend: Vue.js 3, TypeScript, Pinia, Chart.js, VueRouter, Axios, UIkit, Vite, ESlint

Backend: Laravel 10, PHP 8.3, Redis, MySQL

Docker, Nginx, PHP:8.3-FPM

## Features

- Admin panel with the ability to manage products, view statistics and orders, products in the form of lists and tables.
- Displaying monthly statistics on orders and best-selling products using chart.js
- RESTful API with roles. Admin panel
- Deploying an application via docker
- SPA
- ERP
- Caching frequently accessed data using redis
- The project is covered with tests

## Run Locally

Clone the project

```bash
  git clone https://github.com/Denis10491/store
```

Go to the project directory

```bash
  cd store
```

Install dependencies

```bash
  composer install
```

```bash
  npm install
```

Copy from `.env.example` to `.env` and configure the configurations described above

Connect image storage

```bash
  php artisan storage:link
```

Run docker compose

```bash
  docker-compose up -d
```

Generate application key

```bash
  docker-compose exec app php artisan key:generate
```

Run migrations

```bash
  docker-compose exec app php artisan migrate:fresh
```

Run seeds
```bash
  docker-compose exec app php artisan db:seed --class=DatabaseSeeeder
```

Run a local server for the client side

```bash
  npm run dev
```

Add fakestore to hosts in OS
Open project: http://fakestore
