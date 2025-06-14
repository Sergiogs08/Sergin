<?php
// config.php — sin espacios ni BOM antes de <?php

if (file_exists(__DIR__ . '/.env')) {
    Dotenv\Dotenv::createImmutable(__DIR__)->load();
}

define(
  'BASE_URL',
  rtrim($_ENV['BASE_URL'] ?? 'http://localhost:8000', '/') . '/'
);
