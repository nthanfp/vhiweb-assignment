# 📦 VhiWEB E-Procurement System - Backend Developer Test

## 🧾 Deskripsi Proyek

Ini adalah implementasi sistem backend sederhana untuk **E-Procurement** menggunakan **Laravel 12 & PHP 8.2**. Sistem ini mendukung fitur otentikasi, pendaftaran vendor, serta CRUD katalog produk. Selain itu, disediakan juga dokumentasi API berbasis Swagger.

---

## 🔧 Teknologi yang Digunakan

- **Laravel 12**
- **PHP 8.2**
- **Sanctum** – Autentikasi berbasis token
- **L5-Swagger** – Dokumentasi API
- **MySQL** – Database

---

## 🔐 Autentikasi

| Method | Endpoint       | Deskripsi                 |
|--------|----------------|---------------------------|
| POST   | /api/register  | Register user             |
| POST   | /api/login     | Login & ambil token       |
| GET    | /api/profile   | Ambil profil user login   |
| POST   | /api/logout    | Logout & revoke token     |

---

## 🏢 Vendor

| Method | Endpoint       | Deskripsi                       |
|--------|----------------|----------------------------------|
| POST   | /api/vendors   | Daftarkan vendor (1 user = 1)   |

**Field:** `company_name`, `address`, `phone`, `npwp_number`  
**Relasi:** `User hasOne Vendor`

---

## 🛒 Produk

| Method | Endpoint              | Deskripsi              |
|--------|-----------------------|------------------------|
| GET    | /api/products         | List produk vendor     |
| POST   | /api/products         | Tambah produk          |
| GET    | /api/products/{id}    | Detail produk          |
| PUT    | /api/products/{id}    | Update produk          |
| DELETE | /api/products/{id}    | Hapus produk           |

**Field:** `name`, `price`, `stock`, `description`  
**Relasi:** `Vendor hasMany Products`

---

## 📄 Dokumentasi API

Swagger dapat diakses melalui endpoint: /api/documentation

---

## 🚀 Cara Menjalankan

```bash
git clone https://github.com/username/vhiweb-eprocurement.git
cd vhiweb-eprocurement
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve