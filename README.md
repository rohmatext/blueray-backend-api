# Backend Order Shipping & Tracking API

*Aplikasi backend untuk sistem pengiriman dan pelacakan paket menggunakan Laravel, dikembangkan untuk keperluan technical test di Blueray Cargo. Aplikasi ini berbasis API (tanpa frontend) dan menyediakan endpoint untuk autentikasi, manajemen alamat, pengiriman, dan pengguna.*

Untuk repository frontend
[klik disini](https://github.com/rohmatext/blueray-frontend)

---

## Instalasi

1. **Clone repository**

   ```bash
   git clone git@github.com:rohmatext/blueray-backend-api.git
   cd blueray-backend-api
   ```

2. **Install dependensi PHP**

   ```bash
   composer install
   ```

3. **Copy file environment**

   ```bash
   cp .env.example .env
   ```

4. **Generate application key**

   ```bash
   php artisan key:generate
   ```

5. **Setup database**

   * Edit file `.env`, sesuaikan konfigurasi database:

     ```
     DB_CONNECTION=pgsql
     DB_HOST=127.0.0.1
     DB_PORT=5432
     DB_DATABASE=nama_database
     DB_USERNAME=postgres
     DB_PASSWORD=password
     ```

6. **Mengatur API Biteship**

   * Edit file `.env`, dan masukan api Biteship

   ```
   BITSHIP_API_KEY=XXXXXX
   ```

7. **Mengatur URL Frontend**
   * Edit file `.env`, dan masukan url frontend 

   ```
   FRONTEND_URL=http://domainkamu.com
   ```
   > `FRONTEND_URL` digunakan untuk mengatur domain frontend yang diizinkan mengakses API melalui mekanisme CORS (Cross-Origin Resource Sharing). Pastikan URL sesuai dengan domain aplikasi frontend yang akan mengkonsumsi API ini.

8. **Jalankan migrasi dan seeder**

   ```bash
   php artisan migrate --seed
   ```

   Seeder akan membuat 2 role default: `admin` dan `user`

9. **Buat akun admin**

   ```bash
   php artisan create:admin
   ```

   Masukkan data yang diminta untuk membuat akun admin.

---

## Menjalankan Proyek

```bash
php artisan serve
```

Akses aplikasi di `http://localhost:8000`

---

## 📱 Dokumentasi API

### Autentikasi

| Method | Endpoint      | Deskripsi                   | Auth  |
| ------ | ------------- | --------------------------- | ----- |
| POST   | /api/login    | Login dan mendapatkan token | Tidak |
| DELETE | /api/logout   | Logout dan hapus sesi       | Ya    |
| POST   | /api/register | Registrasi pengguna baru    | Tidak |
| PATCH  | /api/password | Update password pengguna    | Ya    |

### Profil

| Method | Endpoint     | Deskripsi                   | Auth |
| ------ | ------------ | --------------------------- | ---- |
| GET    | /api/profile | Mendapatkan profil pengguna | Ya   |
| PATCH  | /api/profile | Update profil pengguna      | Ya   |

### Alamat (Addresses)

| Method | Endpoint                 | Deskripsi               | Auth  |
| ------ | ------------------------ | ----------------------- | ----- |
| GET    | /api/addresses           | List semua alamat       | Ya    |
| POST   | /api/addresses           | Menambahkan alamat baru | Ya    |
| GET    | /api/addresses/{id}      | Detail alamat tertentu  | Ya    |
| PATCH  | /api/addresses/{id}      | Update alamat           | Ya    |
| DELETE | /api/addresses/{id}      | Hapus alamat            | Ya    |
| GET    | /api/addresses/provinces | List semua provinsi     | Ya    |

### Pengiriman (Shipments)

| Method | Endpoint                      | Deskripsi                  | Auth  |
| ------ | ----------------------------- | -------------------------- | ----- |
| GET    | /api/shipments                | List pengiriman            | Ya    |
| POST   | /api/shipments                | Buat pengiriman            | Ya    |
| GET    | /api/shipments/{id}           | Detail pengiriman tertentu | Ya    |
| PATCH  | /api/shipments/{id}           | Update pengiriman          | Ya    |
| DELETE | /api/shipments/{id}           | Hapus pengiriman           | Ya    |
| GET    | /api/shipments/couriers       | List kurir                 | Ya    |
| GET    | /api/shipments/trackings/{id} | Lacak pengiriman           | Ya    |

### Statistik

| Method | Endpoint   | Deskripsi          | Auth |
| ------ | ---------- | ------------------ | ---- |
| GET    | /api/stats | Statistik aplikasi | Ya   |

### Pengguna (Hanya Admin)

| Method | Endpoint        | Deskripsi       | Auth |
| ------ | --------------- | --------------- | ---- |
| GET    | /api/users      | List pengguna   | Ya   |
| GET    | /api/users/{id} | Detail pengguna | Ya   |
| PATCH  | /api/users/{id} | Update pengguna | Ya   |
| DELETE | /api/users/{id} | Hapus pengguna  | Ya   |

### Utilitas

| Method | Endpoint  | Deskripsi       | Auth  |
| ------ | --------- | --------------- | ----- |
| GET    | /api/ping | Cek koneksi API | Tidak |

> **Catatan:** Gunakan token Bearer di header `Authorization` untuk endpoint yang membutuhkan autentikasi.

---

## Cara Menggunakan Aplikasi

1. **Registrasi dan Login**

   * Pengguna dapat mendaftar dan login melalui endpoint API.

2. **Manajemen Alamat**

   * Pengguna dapat membuat, membaca, memperbarui, dan menghapus alamat pengiriman.

3. **Manajemen Pengiriman**

   * Pengguna dapat membuat pengiriman, memilih kurir, dan melacak status pengiriman via API Biteship.

4. **Manajemen Pengguna**

   * Admin dapat mengelola pengguna yang terdaftar dalam sistem.

5. **Fitur Tambahan**

   * Autentikasi berbasis token (Sanctum)
   * Middleware untuk proteksi route
   * Validasi input

---

## Dokumentasi API via Postman

Tersedia file Postman collection untuk menguji endpoint:

📁 `blueray-api.postman_collection.json`

Import ke Postman dan atur environment sesuai token jika diperlukan.

---

## Tools & Teknologi

* Laravel 12.x
* PostgreSQL
* Laravel Sanctum
* RESTful API


## Pengembang

* [Muhammad Rohmat](https://github.com/rohmatext)
