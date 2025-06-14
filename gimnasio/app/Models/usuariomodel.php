<?php
// app/models/UsuarioModel.php
namespace App\Models;

use PDO;
use PDOException;

/**
 * Modelo de usuarios.
 * • KPI y listados por fecha
 * • Alta con tarifa mediante tabla usuario_membresia
 */
class UsuarioModel
{
    /** Columna de fecha de alta en tu tabla `usuarios` */
    private const DATE_FIELD = 'fecha_registro';

    private PDO $pdo;
    public function __construct(PDO $pdo) { $this->pdo = $pdo; }

    /*─────────────── BÚSQUEDAS BÁSICAS ───────────────*/

    public function findByEmail(string $email): ?array
    {
        $st = $this->pdo->prepare(
            'SELECT * FROM usuarios WHERE email = :e LIMIT 1'
        );
        $st->execute(['e' => $email]);
        return $st->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function findById(int $id): ?array
    {
        $st = $this->pdo->prepare(
            'SELECT * FROM usuarios WHERE id = :id LIMIT 1'
        );
        $st->execute(['id' => $id]);
        return $st->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function findAll(): array
    {
        return $this->pdo->query(
            'SELECT * FROM usuarios ORDER BY id DESC'
        )->fetchAll(PDO::FETCH_ASSOC);
    }

    /*─────────────── KPI / FECHAS ────────────────────*/

    public function countAll(): int
    {
        return (int) $this->pdo->query('SELECT COUNT(*) FROM usuarios')
                               ->fetchColumn();
    }

    public function countByRole(string $role): int
    {
        $st = $this->pdo->prepare(
            'SELECT COUNT(*) FROM usuarios WHERE LOWER(rol)=LOWER(:r)'
        );
        $st->execute(['r' => $role]);
        return (int) $st->fetchColumn();
    }

    public function findRecent(int $limit = 5): array
    {
        $f  = self::DATE_FIELD;
        $st = $this->pdo->prepare(
            "SELECT nombre, $f AS fecha
             FROM usuarios
             ORDER BY $f DESC
             LIMIT :l"
        );
        $st->bindValue('l', $limit, PDO::PARAM_INT);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countPerMonth(int $months = 12): array
    {
        $f  = self::DATE_FIELD;
        $sql = "
          SELECT DATE_FORMAT($f,'%Y-%m') mes, COUNT(*) total
          FROM usuarios
          WHERE $f >= DATE_FORMAT(
            DATE_SUB(CURDATE(), INTERVAL :m MONTH), '%Y-%m-01'
          )
          GROUP BY mes ORDER BY mes
        ";
        $st = $this->pdo->prepare($sql);
        $st->bindValue('m', $months - 1, PDO::PARAM_INT);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    /*─────────────── CRUD EXTRA ─────────────────────*/

    public function deleteById(int $id): bool
    {
        $st = $this->pdo->prepare('DELETE FROM usuarios WHERE id = :id');
        return $st->execute(['id' => $id]);
    }

    public function findByRole(string $role): array
    {
        $st = $this->pdo->prepare(
            'SELECT * FROM usuarios WHERE LOWER(rol)=LOWER(:r) ORDER BY id DESC'
        );
        $st->execute(['r' => $role]);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    /*─────────────── ALTA CON TARIFA ────────────────*/

    /**
     * Crea el usuario y lo vincula a una tarifa en `usuario_membresia`.
     * Espera: ['nombre','email','membresia_id']
     */
    public function createWithTarifa(array $d): bool
    {
        $this->pdo->beginTransaction();
        try {
            /* 1) insertar usuario */
            $sqlU = "
              INSERT INTO usuarios (nombre, email, password, rol)
              VALUES (:n, :e, '', 'usuario')
            ";
            $stU = $this->pdo->prepare($sqlU);
            $stU->execute([
                'n' => trim($d['nombre'] ?? ''),
                'e' => trim($d['email']  ?? ''),
            ]);
            $userId = (int) $this->pdo->lastInsertId();

            /* 2) vincular con membresía */
            $sqlM = "
              INSERT INTO usuario_membresia (usuario_id, membresia_id, fecha_inicio)
              VALUES (:u, :m, CURDATE())
            ";
            $stM = $this->pdo->prepare($sqlM);
            $stM->execute([
                'u' => $userId,
                'm' => (int) ($d['membresia_id'] ?? 0),
            ]);

            return $this->pdo->commit();
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    /*─────────────── LISTA CON TARIFA ──────────────*/

    /**
     * Devuelve todos los usuarios junto con el nombre de su tarifa (si tiene).
     * Campo extra en el array: 'tarifa'
     */
    public function findAllWithTarifa(): array
    {
        $sql = "
          SELECT u.*,
                 m.nombre_plan AS tarifa
          FROM usuarios u
          LEFT JOIN usuario_membresia um ON um.usuario_id = u.id
          LEFT JOIN membresias        m ON m.id = um.membresia_id
          ORDER BY u.id DESC
        ";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}


