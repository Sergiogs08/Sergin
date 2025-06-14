<?php
// app/Core/Controller.php
namespace App\Core;

class Controller
{
    /**
     * Carga y devuelve una instancia de modelo.
     * @param string $model Nombre de la clase de modelo (sin namespace)
     */
    protected function model(string $model)
    {
        $modelClass = "\\App\\Models\\{$model}";
        // Tomamos la conexión de entorno
        $host = $_ENV['DB_HOST']    ?? $_SERVER['DB_HOST']    ?? getenv('DB_HOST');
        $db   = $_ENV['DB_NAME']    ?? $_SERVER['DB_NAME']    ?? getenv('DB_NAME');
        $user = $_ENV['DB_USER']    ?? $_SERVER['DB_USER']    ?? getenv('DB_USER');
        $pass = $_ENV['DB_PASS']    ?? $_SERVER['DB_PASS']    ?? getenv('DB_PASS');
        $dsn  = "mysql:host={$host};dbname={$db};charset=utf8";

        $pdo = new \PDO($dsn, $user, $pass, [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        ]);

        return new $modelClass($pdo);
    }

    /**
     * Renderiza una vista pasando datos.
     * @param string $view Ruta relativa a app/views (usar puntos para carpetas)
     * @param array  $data Datos a extraer en la vista
     */
    protected function view(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        require __DIR__ . "/../views/" . str_replace('.', '/', $view) . ".php";
    }
}

