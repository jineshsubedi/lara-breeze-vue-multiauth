# MULTI AUTH SYSTEM

User has different dashboard from a single login form.

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