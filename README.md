# Bunny Shop 🐰

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
| Auth      | Laravel Breeze                    |

## Requirements

- PHP >= 8.2
- Composer
- Node.js >= 18 & npm
- MySQL (provided by Laragon, Herd, or XAMPP)

---

## Installation

Choose the guide that matches your local environment:

- [Laragon (Windows)](#laragon-windows)
- [Herd (Windows / macOS)](#herd-windows--macos)
- [XAMPP (Windows / macOS)](#xampp-windows--macos)

---

## Laragon (Windows)

### 1. Clone the repository

Place the project inside Laragon's web root:

```bash
cd C:\laragon\www
git clone https://github.com/kurt-ds/bunny_shop.git
cd bunny_shop
```

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

### 4. Configure `.env`

Open `.env` and set your database credentials (Laragon uses no password by default):

```env
APP_URL=http://bunny_shop.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bunny_shop
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Run migrations and seeders

When prompted to create the database, type `yes`.

```bash
php artisan migrate --seed
```

### 6. Create the storage symlink

```bash
php artisan storage:link
```

### 7. Build frontend assets

```bash
npm run dev
```

### 8. Access the app

Laragon auto-creates a virtual host. Open `http://bunny_shop.test` in your browser.

---

## Herd (Windows / macOS)

### 1. Clone the repository

Place the project inside Herd's directory:

```bash
# Windows
cd %USERPROFILE%\Herd
git clone https://github.com/kurt-ds/bunny_shop.git

# macOS
cd ~/Herd
git clone https://github.com/kurt-ds/bunny_shop.git
```

```bash
cd bunny_shop
```

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

### 4. Configure `.env`

Open `.env` and set your database credentials (Herd uses no password by default):

```env
APP_URL=http://bunny_shop.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bunny_shop
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Run migrations and seeders

When prompted to create the database, type `yes`.

```bash
php artisan migrate --seed
```

### 6. Create the storage symlink

```bash
php artisan storage:link
```

### 7. Build frontend assets

```bash
npm run dev
```

### 8. Access the app

Herd auto-detects the project. Open `http://bunny_shop.test` in your browser.

---

## XAMPP (Windows / macOS)

> XAMPP requires a few one-time Apache config changes before the app will work correctly. Laravel must be served from the `public/` folder and needs `mod_rewrite` enabled.

### 1. Clone the repository

Place the project inside XAMPP's web root:

```bash
# Windows
cd C:\xampp\htdocs
git clone https://github.com/kurt-ds/bunny_shop.git

# macOS
cd /Applications/XAMPP/htdocs
git clone https://github.com/kurt-ds/bunny_shop.git
```

### 2. Install dependencies

```bash
cd bunny_shop
composer install
npm install
```

### 3. Configure Apache

Open the XAMPP Control Panel, find the **Apache** row, and click the **Config** button on that row. From the dropdown, click **httpd.conf**. The file will open in a text editor.

**a) Change the DocumentRoot**

Press `Ctrl+F` and search for `DocumentRoot`. You will find a line that looks like this:

```apacheconf
DocumentRoot "C:/xampp/htdocs"
```

Change it to point to the project's `public` folder:

```apacheconf
# Windows
DocumentRoot "C:/xampp/htdocs/bunny_shop/public"

# macOS
DocumentRoot "/Applications/XAMPP/htdocs/bunny_shop/public"
```

**b) Change the Directory path**

Just below the `DocumentRoot` line, there is a matching `<Directory>` block. Update its path to match:

```apacheconf
# Windows
<Directory "C:/xampp/htdocs/bunny_shop/public">

# macOS
<Directory "/Applications/XAMPP/htdocs/bunny_shop/public">
```

**c) Save the file and restart Apache** from the XAMPP Control Panel.

### 4. Set up environment file

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configure `.env`

Open `.env` and set your database credentials (XAMPP uses no password by default):

```env
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bunny_shop
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Run migrations and seeders

When prompted to create the database, type `yes`.

```bash
php artisan migrate --seed
```

### 7. Create the storage symlink

```bash
php artisan storage:link
```

### 8. Build frontend assets

```bash
npm run dev
```

### 9. Access the app

Open `http://localhost` in your browser.

---

## Seed Images

The seed bunny images are stored in `storage/app/public/bunnies/` and are included in the repository. After running `php artisan storage:link`, they will be accessible automatically.

Future uploads made through the app are excluded from version control via the folder's `.gitignore`.
