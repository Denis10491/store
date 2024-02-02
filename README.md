
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

## API Reference

#### Create new account

```http
  POST /api/register
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `email` | `string` | **Required** |
| `name` | `string` | **Required** |
| `password` | `string` | **Required** |

#### Login to account

```http
  POST /api/login
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `email` | `string` | **Required** |
| `password` | `string` | **Required** |

#### Get products page

```http
  GET /api/products/index/${id}
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `id` | `string` | **Required**. Id of item to fetch |

#### Get product by id

```http
  GET /api/products/show/${id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Required**. Id of item to fetch |

#### Get info about user

```http
  GET /api/user/show
```

|  Header  | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Authorization`      | `Bearer ${token}` | **Required** |

#### Logout from account

```http
  POST /api/logout
```

|  Header  | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Authorization`| `Bearer ${token}` | **Required** |

#### Create new order

```http
  POST /api/orders/store
```

|  Header  | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Authorization`| `Bearer ${token}` | **Required** |

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `address`| `string` | **Required** |

#### Get page orders of the current authorized user

```http
  GET /api/orders/show/${page}
```

|  Header  | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Authorization`| `Bearer ${token}` | **Required** |

#### Get page orders (admin only)

```http
  GET /api/orders/index/${page}
```

|  Header  | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Authorization`| `Bearer ${token}` | **Required** |

#### Create new product (admin only)

```http
  POST /api/products/store
```

|  Header  | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Authorization`| `Bearer ${token}` | **Required** |

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Required**. Id of item to fetch |
| `name`    | `string` | **Required** |
| `description` | `string` | **Required** |
| `image`   | `file`   | **Required** |
| `composition`   | `string`   | **Required** |
| `price`      | `int` | **Required** |
| `proteins`      | `string` | **Required** |
| `fats`      | `string` | **Required** |
| `carbohydrates` | `string` | **Required** |

#### Update product by id (admin only)

```http
  POST /api/products/update/${id}
```

|  Header  | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Authorization`| `Bearer ${token}` | **Required** |
| `Content-Type`| `multipart/form-data` | **Required** |

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Required**. Id of item to fetch |
| `name`    | `string` | Optional |
| `description` | `string` | Optional |
| `image`   | `file`   | Optional. Image of product |
| `composition`   | `string`   | Optional |
| `price`      | `int` | Optional |
| `proteins`      | `string` | Optional |
| `fats`      | `string` | Optional |
| `carbohydrates` | `string` | Optional |

#### Delete product by id (admin only)

```http
  DELETE /api/products/destroy/${id}
```

|  Header  | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Authorization`| `Bearer ${token}` | **Required** |

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Required**. Id of item to fetch |

#### Get order statistics for a month (admin only)

```http
  GET /api/statistics/orders/count
```

|  Header  | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Authorization`| `Bearer ${token}` | **Required** |

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `year`      | `string` | **Required** |
| `month`      | `string` | **Required** |

#### Get statistics of the best-selling products for the month (admin only)

```http
  GET /api/statistics/products/bestselling
```

|  Header  | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Authorization`| `Bearer ${token}` | **Required** |

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `year`      | `string` | **Required** |
| `month`      | `string` | **Required** |