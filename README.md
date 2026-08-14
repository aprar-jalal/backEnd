# Job Portal API - Laravel PHP Backend with Full MVC Structure

A robust, scalable RESTful API backend built with **Laravel 12** and **PHP 8.2+** following a complete Model-View-Controller (MVC) architecture. Designed for job search and recruitment platforms, this application powers user authentication, employer company management, job listings, application tracking, saved favorites, and real-time notifications.

---

## Features

- **Authentication & Authorization**: Secure user registration, login, logout, password reset, and token-based authentication using **Laravel Sanctum**.
- **Employer Management**: Create and manage employer profiles, company size, industry classification, verification, and logo uploads.
- **Job Management**: Full CRUD operations for job postings, including advanced job search, filtering, and detailed job view.
- **Job Seeker Profiles**: Comprehensive candidate profiles supporting resume uploads, profile/background photo customization, and password updates.
- **Application Tracking System (ATS)**: Job seekers can apply for jobs and manage submitted applications; employers can review applicant profiles and update application statuses.
- **Favorites & Bookmarks**: Save and manage favorite job postings for quick access.
- **Real-Time Notifications**: Instant user notifications integrated with **Laravel Reverb** and **Pusher**.

---

## Tech Stack

* **Backend**: PHP 8.2+, Laravel 12
* **Database & ORM**: MySQL / SQLite, Eloquent ORM
* **Authentication**: Laravel Sanctum (Bearer Tokens)
* **Real-time WebSockets**: Laravel Reverb, Pusher PHP Server
* **Asset Bundling & Tooling**: Vite, Composer, NPM
* **Testing & Quality**: PHPUnit, Laravel Pint

---

## Project Structure

```text
Laravel-PHP_backend_with_full-MVC-structure/
├── app/
│   ├── Http/
│   │   ├── Controllers/       # API Controllers handling request logic
│   │   └── Middleware/        # Request filtering & authentication middleware
│   └── Models/                # Eloquent ORM models (User, Job, Employer, JobSeeker, etc.)
├── bootstrap/                 # Application bootstrap & middleware configuration
├── config/                    # System & package configurations
├── database/
│   ├── factories/             # Model factories for testing
│   ├── migrations/            # Database schema migrations
│   └── seeders/               # Database seeders
├── public/                    # Entry point (index.php) and public assets
├── resources/
│   ├── css/                   # Stylesheets & Tailwind setup
│   └── js/                    # Client scripts & WebSocket listeners
├── routes/
│   ├── api.php                # RESTful API route definitions
│   ├── channels.php           # Event broadcasting channels
│   └── web.php                # Web routes
├── storage/                   # File uploads, logs, and application cache
└── tests/                     # Automated PHPUnit tests
```

---

## Getting Started

Follow these steps to get a local development environment up and running.

### Prerequisites

Ensure you have the following installed on your system:

- **PHP** >= 8.2
- **Composer** >= 2.x
- **Node.js** >= 18.x & **NPM**
- **MySQL** database server

### Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/aprar-jalal/Laravel-PHP_backend_with_full-MVC-structure.git
   cd Laravel-PHP_backend_with_full-MVC-structure
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install Frontend / Tooling dependencies:**
   ```bash
   npm install
   ```

4. **Copy the Environment File & Generate App Key:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Run Database Migrations & Seeders:**
   ```bash
   php artisan migrate --seed
   ```

### Environment Variables

Configure your database connection and broadcasting settings in `.env`:

```env
APP_NAME="Job Portal Backend"
APP_ENV=local
APP_KEY=base64:...
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=job_portal_db
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_CONNECTION=reverb
REVERB_APP_ID=your_reverb_app_id
REVERB_APP_KEY=your_reverb_app_key
REVERB_APP_SECRET=your_reverb_app_secret
```

### Run the Application

Start the local development server:

```bash
php artisan serve
```

Or run all development services concurrently (Server, Queue, and Vite):

```bash
composer dev
```

The API server will be available at `http://127.0.0.1:8000`.

---

## API Integration

The frontend application communicates with this backend over **HTTP/REST** endpoints using JSON payloads. Protected routes require a `Bearer <token>` HTTP header via **Laravel Sanctum**.

## Available Scripts

Here are the primary scripts defined in `composer.json` and `package.json`:

| Command | Description |
| :--- | :--- |
| `php artisan serve` | Starts the Laravel development server |
| `composer dev` | Concurrently runs artisan serve, queue worker, and Vite dev server |
| `composer test` | Clears configuration cache and executes automated PHPUnit tests |
| `npm run dev` | Starts Vite asset bundler in watch mode |
| `npm run build` | Bundles frontend assets for production deployment |

---
