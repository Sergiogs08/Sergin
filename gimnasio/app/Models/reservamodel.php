<?php
namespace App\Models;

use PDO;

class ReservaModel
{
    private PDO $pdo;
    public function __construct(PDO $pdo) { $this->pdo = $pdo; }

    /** Nº total de reservas */
    public function countAll(): int
    {
        return (int) $this->pdo->query('SELECT COUNT(*) FROM reservas')->fetchColumn();
    }

    /** Todas las reservas con datos de usuario y clase */
    public function findAllDetailed(int $limit = null): array
    {
        $sql = "
          SELECT r.id,
                 u.nombre  AS cliente,
                 c.titulo  AS clase,
                 c.fecha,
                 c.hora,
                 r.fecha_reserva
          FROM reservas r
          JOIN usuarios u ON u.id = r.usuario_id
          JOIN clases   c ON c.id = r.clase_id
          ORDER BY r.fecha_reserva DESC
        ";
        if ($limit) $sql .= " LIMIT $limit";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}

