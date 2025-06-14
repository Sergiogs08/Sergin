<?php declare(strict_types=1);declare(strict_types=1);

namespace App\Controllers;

use App\Models\UsuarioModel;
use PDO;

class AuthController
{
    private UsuarioModel $usuarioModel;

    public function __construct()
    {
        // Conectar a la BD leyendo del .env
        $host = $_ENV['DB_HOST'] ?? '127.0.0.1';
        $db   = $_ENV['DB_NAME'] ?? 'gimnasio';
        $user = $_ENV['DB_USER'] ?? 'root';
        $pass = $_ENV['DB_PASS'] ?? '';

        $dsn = "mysql:host={$host};dbname={$db};charset=utf8";
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);

        $this->usuarioModel = new UsuarioModel($pdo);

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public function index(): void
    {
        $this->login();
    }

    public function login(): void
    {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $u = $this->usuarioModel->findByEmail($email);

            if ($u && password_verify($password, $u['password'])) {
                // Regeneramos ID de sesiÃ³n para mayor seguridad
                session_regenerate_id(true);

                // Forzamos el rol a minÃºsculas
                $rolNorm = strtolower($u['rol']);
                $_SESSION['user_id'] = $u['id'];
                $_SESSION['rol']     = $rolNorm;

                // Redirigimos segÃºn rol
                switch ($rolNorm) {
                    case 'recepcionista':
                        header('Location: ' . BASE_URL . 'recepcionista/dashboard');
                        break;
                    case 'administrador':
                        header('Location: ' . BASE_URL . 'administrador/dashboard');
                        break;
                    case 'usuario':
                        header('Location: ' . BASE_URL . 'usuario/dashboard');
                        break;
                    case 'entrenador':
                        header('Location: ' . BASE_URL . 'entrenador/dashboard');
                        break;
                    default:
                        header('Location: ' . BASE_URL . 'auth/index');
                        break;
                }
                exit;
            }

            // Si llegamos aquÃ­, hubo un error
            $error = !$u
                ? "Usuario con email \"$email\" NO encontrado."
                : 'ContraseÃ±a incorrecta.';
            $error = htmlspecialchars($error, ENT_QUOTES, 'UTF-8');
        }

        require __DIR__ . '/../views/auth/login.php';
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: ' . BASE_URL . 'auth/index');
        exit;
    }
}
