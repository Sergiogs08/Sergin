# Gimnasio PHP App

This repository contains a small gym management system written in PHP.
It was originally uploaded as a ZIP archive. The project has now been
extracted into the `gimnasio` directory.

## Setup

1. Ensure PHP and Composer are installed.
2. From the `gimnasio` directory run `composer install` to install
   dependencies.
3. Copy `.env` to configure the database connection if needed.
4. Serve the application locally:

```bash
php -S localhost:8000 -t public
```

The SQL schema can be found in `sql/esquema_gimnasio.sql`.

