 # The Cozy Burrow | Bunny Shop 🐰

A full-stack CRUD web application for browsing and managing bunny listings and their breeds. Built with Laravel, Vue 3, Inertia.js, and Tailwind CSS.

## Features

- Browse, create, edit, and delete bunny listings
- Manage bunny breeds (categories)
- Filter by breed and keyword search
- Server-side pagination with configurable items per page
- Image upload support
- Responsive UI

## Tech Stack

| Layer     | Technology                        |
|-----------|-----------------------------------|
| Backend   | Laravel 11, Inertia.js            |
| Frontend  | Vue 3, Tailwind CSS, Axios        |
| Database  | MySQL                             |

## Requirements

- PHP >= 8.2
- Composer
- Node.js >= 18 & npm
- MySQL (provided by Laragon, Herd, or XAMPP)

---

## Installation 

### 1. Clone the repository

```bash
git clone https://github.com/kurt-ds/bunny_shop.git
cd bunny_shop
```
File location of the folder depends on what local hosting you use. For more information, please go to Local Environment Setups

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Set up environment file

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure your database

Open `.env` and set your database credentials. The default assumes MySQL with no password (standard for local dev tools):

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bunny_shop
DB_USERNAME=root
DB_PASSWORD=
```

> Create the `bunny_shop` database first. See the local environment section below for how to do this with your tool.

### 5. Run migrations and seeders

```bash
php artisan migrate --seed
```

### 6. Create the storage symlink

This links `storage/app/public` to `public/storage` so uploaded images are accessible:

```bash
php artisan storage:link
```

### 7. Build frontend assets

For development (with hot reload):
```bash
npm run dev
```

For production:
```bash
npm run build
```

---

## Local Environment Setup

### Laragon (Windows)

1. Place the project folder inside `C:\laragon\www\bunny_shop`
2. Start Laragon and ensure Apache and MySQL are running
3. Open **HeidiSQL** (bundled with Laragon) or the Laragon database panel and create a database named `bunny_shop`
4. Laragon auto-creates a virtual host — access the app at `http://bunny_shop.test`
5. No password is set by default (`DB_PASSWORD=` can stay empty)

### Herd (macOS)

1. Place the project folder inside `~/Herd/bunny_shop`
2. Start Herd — it auto-detects the project
3. Create the `bunny_shop` database using a GUI tool like TablePlus, DBngin, or via terminal:
   ```bash
   mysql -u root -e "CREATE DATABASE bunny_shop;"
   ```
4. Access the app at `http://bunny_shop.test`
5. Herd uses no password by default (`DB_PASSWORD=` can stay empty)

### XAMPP (Windows / macOS)

> **Important:** Laravel requires Apache to serve from the `public/` folder and needs `mod_rewrite` enabled. The steps below configure this by pointing XAMPP's document root directly at the project.

#### 1. Place the project

- **Windows:** `C:\xampp\htdocs\bunny_shop`
- **macOS:** `/Applications/XAMPP/htdocs/bunny_shop`


#### 2. Point the document root to the `public` folder

In Xampp, click Config button on the row of Apache, then click the `httpd.conf` file,  CTRL+F to find the `DocumentRoot` and `<Directory>` lines and update them:

**Windows:**
```apacheconf
DocumentRoot "C:/xampp/htdocs/bunny_shop/public"
<Directory "C:/xampp/htdocs/bunny_shop/public">
```

**macOS:**
```apacheconf
DocumentRoot "/Applications/XAMPP/htdocs/bunny_shop/public"
<Directory "/Applications/XAMPP/htdocs/bunny_shop/public">
```

#### 3. Create the database

Start Apache and MySQL from the XAMPP Control Panel, then open **phpMyAdmin** at `http://localhost/phpmyadmin` and create a database named `bunny_shop`. (Skip if you already run the seeders, if not then rerun the seeders after this point)

#### 4. Restart Apache

Restart Apache from the XAMPP Control Panel to apply all config changes.

#### 5. Access the app

Open `http://localhost` — this now points directly to the app.

> No password is set by default (`DB_PASSWORD=` can stay empty).

---

## Seed Images

The seed bunny images are stored in `storage/app/public/bunnies/` and are included in the repository. After running `php artisan storage:link`, they will be accessible automatically.

Future uploads made through the app are excluded from version control via the folder's `.gitignore`.
