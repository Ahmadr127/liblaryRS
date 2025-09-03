# Sistem Perpustakaan RS dengan Role-Based Access Control

Sistem perpustakaan yang dibangun dengan Laravel dan menggunakan sistem autentikasi dengan role dinamis untuk mengelola akses pengguna.

## Fitur Utama

- **Sistem Autentikasi**: Login, register, dan logout
- **Role-Based Access Control**: Sistem role dan permission yang dinamis
- **UI Modern**: Menggunakan Tailwind CSS untuk tampilan yang responsif
- **CRUD Operations**: Manajemen roles dan permissions
- **Middleware Protection**: Proteksi route berdasarkan permission

## Struktur Role dan Permission

### Roles
- **Administrator**: Akses penuh ke semua fitur
- **Pustakawan**: Mengelola buku dan peminjaman
- **Pengguna**: Akses terbatas ke dashboard

### Permissions
- `manage_roles`: Kelola roles dan permissions
- `manage_permissions`: Kelola permissions
- `view_dashboard`: Lihat halaman dashboard
- `manage_users`: Kelola pengguna
- `manage_books`: Kelola data buku
- `manage_borrowings`: Kelola peminjaman buku
- `view_reports`: Lihat laporan sistem

## Instalasi

### 1. Clone Repository
```bash
git clone <repository-url>
cd liblaryRS
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Setup Environment
```bash
cp .env.example .env
```

Edit file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=liblaryrs
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Run Migrations dan Seeder
```bash
php artisan migrate
php artisan db:seed
```

### 6. Start Development Server
```bash
php artisan serve
```

## Akun Default

Setelah menjalankan seeder, akun default yang tersedia:

- **Email**: admin@example.com
- **Password**: password (sesuai factory)
- **Role**: Administrator

## Penggunaan

### Login
1. Buka http://localhost:8000
2. Masuk dengan akun yang sudah ada atau daftar akun baru
3. Pilih role saat mendaftar

### Manajemen Role
1. Login sebagai admin
2. Akses menu "Roles" di navbar
3. Buat, edit, atau hapus role sesuai kebutuhan
4. Assign permissions ke role

### Manajemen Permission
1. Login sebagai admin
2. Akses menu "Permissions" di navbar
3. Buat permission baru sesuai kebutuhan

## Struktur Database

### Tabel Users
- `id`, `name`, `email`, `password`, `role_id`, `created_at`, `updated_at`

### Tabel Roles
- `id`, `name`, `display_name`, `description`, `created_at`, `updated_at`

### Tabel Permissions
- `id`, `name`, `display_name`, `description`, `created_at`, `updated_at`

### Tabel Role_Permission (Pivot)
- `id`, `role_id`, `permission_id`, `created_at`, `updated_at`

## Middleware

### CheckPermission
Middleware untuk mengecek permission pengguna:
```php
Route::middleware('permission:manage_roles')->group(function () {
    // Routes yang memerlukan permission manage_roles
});
```

## Helper Methods

### User Model
- `hasRole($role)`: Cek apakah user memiliki role tertentu
- `hasPermission($permission)`: Cek apakah user memiliki permission tertentu

### Role Model
- `hasPermission($permission)`: Cek apakah role memiliki permission tertentu

## Contributing

1. Fork repository
2. Buat branch fitur baru
3. Commit perubahan
4. Push ke branch
5. Buat Pull Request

## License

Proyek ini menggunakan MIT License.
# liblaryRS
