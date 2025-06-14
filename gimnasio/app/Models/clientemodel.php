<?php
namespace App\Models;

use PDO;

class ClienteModel
{
    /* relación directa en la tabla `usuarios` */
    private const TRAINER_COL = 'trainer_id';

    private PDO $pdo;
    public function __construct(PDO $pdo) { $this->pdo = $pdo; }

    /** Devuelve los clientes asignados a un entrenador */
    public function findByTrainer(int $trainerId): array
    {
        $sql = sprintf(
            'SELECT id, nombre
             FROM usuarios
             WHERE %s = :id AND rol = "usuario"
             ORDER BY nombre',
            self::TRAINER_COL
        );
        $st = $this->pdo->prepare($sql);
        $st->execute(['id' => $trainerId]);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
}

