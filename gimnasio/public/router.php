<?php declare(strict_types=1);

ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting(E_ALL);

// ── 0) Servir archivos estáticos si existen (PHP built-in server) ───────
if (php_sapi_name() === 'cli-server') {
    $uri  = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $file = __DIR__ . rawurldecode($uri);
    if (is_file($file)) {
        return false;   // deja que el servidor CLI sirva el archivo
    }
}

// ── 1) Autoload + configuración ─────────────────────────────────────────
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config.php';

// ── 2) Sesión global ────────────────────────────────────────────────────
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// ── 3) Carga de controladores ──────────────────────────────────────────
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/RecepcionistaController.php';
require_once __DIR__ . '/../app/controllers/AdministradorController.php';
require_once __DIR__ . '/../app/controllers/UsuarioController.php';
require_once __DIR__ . '/../app/controllers/EntrenadorController.php';

use App\Controllers\AuthController;
use App\Controllers\RecepcionistaController;
use App\Controllers\AdministradorController;
use App\Controllers\UsuarioController;
use App\Controllers\EntrenadorController;

// ── 4) Tabla de rutas ──────────────────────────────────────────────────
$routes = [
    'auth'          => AuthController::class,
    'recepcionista' => RecepcionistaController::class,
    'administrador' => AdministradorController::class,
    'usuario'       => UsuarioController::class,
    'entrenador'    => EntrenadorController::class,
];

// ── 5) Parsear URL ──────────────────────────────────────────────────────
$uriParts = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$parts    = explode('/', $uriParts);
$route    = $parts[0] ?: 'auth';
$method   = $parts[1] ?? 'index';

// ── 6) Controlador válido ──────────────────────────────────────────────
if (! isset($routes[$route])) {
    header('HTTP/1.0 404 Not Found');
    exit("Controlador '{$route}' no existe.");
}

$controller = new ($routes[$route])();
if (! method_exists($controller, $method)) {
    header('HTTP/1.0 404 Not Found');
    exit("Método '{$method}' no encontrado en controlador '{$route}'.");
}

call_user_func([$controller, $method]);

