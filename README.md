# Portfolio Backend API

Backend API cho website portfolio cá nhân được xây dựng với Laravel 11, tuân theo Clean Architecture và best practices.

## 📋 Yêu cầu hệ thống

- PHP >= 8.3
- Composer
- MySQL >= 5.7 hoặc MariaDB >= 10.3
- Laravel 11

## 🚀 Cài đặt

### 1. Cài đặt dependencies

```bash
composer install
```

### 2. Cấu hình môi trường

Sao chép file `.env.example` thành `.env`:

```bash
cp .env.example .env
```

Cập nhật các thông tin database trong file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portfolio_db
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Tạo application key

```bash
php artisan key:generate
```

### 4. Chạy migrations

```bash
php artisan migrate
```

### 5. Khởi chạy server

```bash
php artisan serve
```

Server sẽ chạy tại: `http://localhost:8000`

## 📁 Cấu trúc dự án

Dự án tuân theo Clean Architecture với các layer:

```
app/
├── Http/
│   ├── Controllers/
│   │   └── Api/
│   │       └── ProjectController.php    # Controller xử lý API requests
│   └── Requests/
│       ├── StoreProjectRequest.php       # Validation cho tạo project
│       └── UpdateProjectRequest.php     # Validation cho cập nhật project
├── Models/
│   └── Project.php                      # Eloquent Model
├── Repositories/
│   ├── Contracts/
│   │   └── ProjectRepositoryInterface.php  # Repository Interface
│   └── ProjectRepository.php            # Repository Implementation
├── Services/
│   └── ProjectService.php               # Service layer (Business Logic)
└── Traits/
    └── ApiResponse.php                  # Trait cho JSON response chuẩn
```

