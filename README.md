
# Store (Vue 3 / Laravel 10)

Frontend stack: Vue.js 3, TypeScript, Pinia, Chart.js, VueRouter, Axios, UIkit, Vite, Eslint

Backend stack: Laravel 10, Docker, Spatie, MySQL


## Features

- Admin panel with the ability to manage products, view statistics and a list of orders with filters. 
- Displaying monthly statistics on orders and best-selling products using chart.js
- RESTful API with roles. Admin panel
- Deploying an application via docker
- SPA with using a Vue Router and custom middlewares
- Profile with the ability to view orders with filters
- Viewing orders and products in the form of lists and tables

## Config

Admin account
- Login: admin@admin
- Password: admin
- Path: /admin

Database
- DB_CONNECTION=mysql
- DB_HOST: mysql
- DB_PORT: 3306
- DB_DATABASE: storedb
- DB_USERNAME: root
- DB_PASSWORD: root


## Run Locally

Clone the project
```bash
  git clone https://github.com/Divrun/Store-Laravel-Vue
```

Go to the project directory
```bash
  cd Store-Laravel-Vue
```

Run docker build an application image
```bash
  docker build -t vuelaravel .
```

Run docker compose
```bash
  docker compose up
```

Run docker compose
```bash
  docker compose exec app php artisan key:generate
```

Run migrations and seeds
```bash
  docker compose exec app php artisan migrate:fresh --seed
```

Connect image storage
```bash
  docker compose exec app php artisan storage:link
```

Open project: http://127.0.0.1:8000