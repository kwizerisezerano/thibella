# Thibella Backend API

Base URL: `http://localhost/Thibella/backend`

All responses:
```json
{ "success": true,  "message": "...", "data": ... }
{ "success": false, "message": "..." }
```
Paginated responses also include:
```json
{ "pagination": { "page": 1, "limit": 16, "total": 100, "total_pages": 7 } }
```

Protected routes need: `Authorization: Bearer <token>`

---

## Getting Started

### 1. Install dependencies
```bash
cd C:\xampp\htdocs\thibella
C:\xampp\php\php.exe backend\composer.phar install
```
> This installs `firebase/php-jwt` into `backend/vendor/`. Only needed once.

### 2. Configure environment
Copy or edit `backend/.env` — set your DB credentials and keys:
```
DB_HOST=localhost
DB_USER=root
DB_PASSWORD=
DB_NAME=thibella_db
ENCRYPTION_KEY=<32-byte hex key>
JWT_SECRET=<secret>
ADMIN_NAME=Thibella
ADMIN_EMAIL=admin@thibella.com
ADMIN_PHONE=+250700000000
ADMIN_PASSWORD=Thibella@2025
```

### 3. Run the migration
```bash
cd C:\xampp\htdocs\thibella
C:\xampp\php\php.exe backend\migration\migrate.php
```

This will:
1. Create the `thibella_db` database if it doesn't exist
2. Create all tables (`categories`, `subcategories`, `users`, `products`, `orders`, `order_items`)
3. Seed all categories and subcategories
4. Create the default admin user with encrypted fields (see below)

### Default Admin User

| Field    | Value                |
|----------|----------------------|
| Name     | `Thibella`           |
| Email    | `admin@thibella.com` |
| Phone    | `+250700000000`      |
| Password | `Thibella@2025`      |
| Role     | `admin`              |

> Password is stored as a bcrypt hash (`PASSWORD_DEFAULT`) in the database.
> Change it after first login.

---

## Auth  `/api/auth`

| Method | Endpoint             | Auth | Body |
|--------|----------------------|------|------|
| POST   | `/api/auth/register` | —    | `{ name, email, phone, password }` |
| POST   | `/api/auth/login`    | —    | `{ email, password }` |

Login response:
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "token": "<jwt>",
    "id": 1,
    "name": "Thibella",
    "email": "admin@thibella.com",
    "phone": "+250700000000",
    "role": "admin"
  }
}
```

---

## Categories  `/api/categories`

| Method | Endpoint              | Auth  | Query / Body |
|--------|-----------------------|-------|--------------|
| GET    | `/api/categories`     | —     | `?id=` `?slug=` `?with_subcategories=1` |
| POST   | `/api/categories`     | Admin | `{ title, slug, description?, image? }` |
| PUT    | `/api/categories?id=` | Admin | any of `{ title, description, slug, image }` |
| DELETE | `/api/categories?id=` | Admin | — |

Query params:
- `?id=1` — single category by id
- `?slug=cars` — single category by slug
- `?with_subcategories=1` — embed subcategories array in each category

---

## Subcategories  `/api/subcategories`

| Method | Endpoint                  | Auth  | Query / Body |
|--------|---------------------------|-------|--------------|
| GET    | `/api/subcategories`      | —     | `?id=` `?slug=` `?category_id=` `?with_category=1` |
| POST   | `/api/subcategories`      | Admin | `{ name, slug, category_id, image? }` |
| PUT    | `/api/subcategories?id=`  | Admin | any of `{ name, slug, category_id, image }` |
| DELETE | `/api/subcategories?id=`  | Admin | — |

Query params:
- `?id=1` — single subcategory by id
- `?slug=sneakers` — single subcategory by slug
- `?category_id=2` — all subcategories belonging to a category
- `?with_category=1` — embed parent category object in each result

---

## Products  `/api/products`

| Method | Endpoint            | Auth  | Query / Body |
|--------|---------------------|-------|--------------|
| GET    | `/api/products`     | —     | see filters below |
| POST   | `/api/products`     | Admin | multipart/form-data (see fields below) |
| PUT    | `/api/products?id=` | Admin | JSON body: any product fields |
| DELETE | `/api/products?id=` | Admin | — |

GET query params:
| Param            | Description |
|------------------|-------------|
| `?id=`           | Single product by id |
| `?category_id=`  | Filter by category |
| `?subcategory_id=` | Filter by subcategory |
| `?sale=1`        | On-sale products only |
| `?search=jordan` | Search by product name |
| `?sort=`         | `newest` (default) `oldest` `price_asc` `price_desc` |
| `?page=`         | Page number (default: 1) |
| `?limit=`        | Items per page (default: 16, max: 100) |

POST fields (multipart/form-data):
| Field               | Required | Type   |
|---------------------|----------|--------|
| `productName`       | ✔        | string |
| `category_id`       | ✔        | int    |
| `description`       |          | string |
| `priceCents`        |          | int    |
| `subCategory_id`    |          | int    |
| `type`              |          | string |
| `isOnSale`          |          | 0 or 1 |
| `imageUrl`          |          | string |
| `size`              |          | JSON string e.g. `["S","M","L"]` |
| `color`             |          | JSON string e.g. `["Red","Blue"]` |
| `possibleImagesUrls`|          | JSON string e.g. `["url1","url2"]` |

---

## Orders  `/api/orders`

| Method | Endpoint                     | Auth  | Query / Body |
|--------|------------------------------|-------|--------------|
| GET    | `/api/orders`                | Admin | `?page=` `?limit=` `?status=` |
| GET    | `/api/orders/user?user_id=5` | Auth  | — |
| POST   | `/api/orders`                | Auth  | JSON body (see fields below) |
| PUT    | `/api/orders?id=`            | Admin | `{ status }` |

GET query params (admin):
- `?status=` — filter by `pending` `processing` `shipped` `delivered` `cancelled`

POST body fields:
| Field               | Required |
|---------------------|----------|
| `userId`            | ✔        |
| `fullName`          | ✔        |
| `phoneNumber`       | ✔        |
| `email`             | ✔        |
| `country`           |          |
| `province`          |          |
| `district`          |          |
| `sector`            |          |
| `nearbyLandmark`    |          |
| `paymentMethod`     | ✔        |
| `mobileMoneyNumber` |          |
| `orderItems`        | ✔        |

Each `orderItems` entry:
```json
{
  "productId": 1,
  "productName": "Converse",
  "priceCents": 30000,
  "quantity": 2,
  "selectedColor": "Brown",
  "selectedSize": "41",
  "imageUrl": "https://..."
}
```

PUT updates order status — allowed values: `pending` `processing` `shipped` `delivered` `cancelled`

---

## Users  `/api/users`

| Method | Endpoint                 | Auth  | Query / Body |
|--------|--------------------------|-------|--------------|
| GET    | `/api/users`             | Admin | `?page=` `?limit=` |
| GET    | `/api/users/profile?id=` | Auth  | — |
| PUT    | `/api/users/profile?id=` | Auth  | `{ name?, phone? }` |
| DELETE | `/api/users?id=`         | Admin | — |

---

## File Structure

```
backend/
├── index.php                   ← front controller — all URLs route here
├── .htaccess                   ← rewrites everything to index.php
├── config/
│   ├── database.php            ← DB host, user, password, database
│   └── jwt.php                 ← secret key, issuer, expiry
├── core/
│   ├── DB.php                  ← mysqli singleton + helpers (fetchOne, fetchAll, insert, execute, count)
│   ├── Response.php            ← json() / success() / error() / paginated()
│   ├── headers.php             ← CORS + Content-Type headers
│   └── helpers.php             ← getPagination, qStr, qInt, jsonBody, buildUpdate
├── middleware/
│   ├── auth.php                ← validates JWT → sets $authUser
│   └── admin.php               ← requires $authUser role === admin
├── controllers/
│   ├── AuthController.php      ← register, login
│   ├── CategoryController.php  ← CRUD + with_subcategories
│   ├── SubcategoryController.php ← CRUD + with_category
│   ├── ProductController.php   ← CRUD + filters + sort + pagination
│   ├── OrderController.php     ← place order, list, user orders, update status
│   └── UserController.php      ← list users, profile get/update, delete
├── routes/
│   ├── auth.php
│   ├── categories.php
│   ├── subcategories.php
│   ├── products.php
│   ├── orders.php
│   └── users.php
└── migration/
    └── migrate.php             ← additive migration runner — creates tables, seeds data, encrypts admin user
```
