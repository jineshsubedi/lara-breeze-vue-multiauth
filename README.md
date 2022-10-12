# MULTI AUTH SYSTEM

Foobar is a Python library for dealing with word pluralization.

## Installation
Use composer

```bash
composer install
npm install
```

## Configuration
Copy .env.example into .env

### Update
```
DB_DATABASE=your_database
LOG_CHANNEL=daily
FILESYSTEM_DISK=public
QUEUE_CONNECTION=database
```

### Commands
```
php artisan migrate --seed
php artisan key:generate
php artisan storage:link
```

## Usage

```
npm run dev
php artisan serve
```