<?php
// app/models/ClaseModel.php
namespace App\Models;

use PDO;

class ClaseModel
{
    /*-------------------------------------------------------------
     | Coinciden con tu tabla `clases`
     |------------------------------------------------------------*/
    private const NAME_FIELD  = 'titulo';        // varchar
    private const DATE_FIELD  = 'fecha';         // date
    private const TIME_FIELD  = 'hora';          // time
    private const TRAINER_ID  = 'entrenador_id'; // FK → usuarios.id
    /*------------------------------------------------------------*/

    private PDO $pdo;
    public function __construct(PDO $pdo) { $this->pdo = $pdo; }

    /** Lista completa ordenada por fecha y hora */
    public function findAll(): array
    {
        $sql = sprintf(
            'SELECT *, %s AS nombre, %s AS fecha, %s AS hora
             FROM clases
             ORDER BY %s, %s',
            self::NAME_FIELD, self::DATE_FIELD, self::TIME_FIELD,
            self::DATE_FIELD, self::TIME_FIELD
        );
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Total de clases */
    public function countAll(): int
    {
        return (int) $this->pdo->query('SELECT COUNT(*) FROM clases')
                               ->fetchColumn();
    }

    /** Próximas N clases desde hoy */
    public function findUpcoming(int $limit = 5): array
    {
        $sql = sprintf(
            'SELECT %s AS nombre, %s AS fecha, %s AS hora
             FROM clases
             WHERE %s >= CURDATE()
             ORDER BY %s, %s
             LIMIT :l',
            self::NAME_FIELD, self::DATE_FIELD, self::TIME_FIELD,
            self::DATE_FIELD,
            self::DATE_FIELD, self::TIME_FIELD
        );
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue('l', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Clases FUTURAS asignadas a un entrenador concreto */
    public function obtenerClasesPorEntrenador(int $entrenadorId): array
    {
        $sql = sprintf(
            'SELECT *, %s AS nombre, %s AS fecha, %s AS hora
             FROM clases
             WHERE %s = :id
               AND %s >= CURDATE()
             ORDER BY %s, %s',
            self::NAME_FIELD, self::DATE_FIELD, self::TIME_FIELD,
            self::TRAINER_ID,
            self::DATE_FIELD,
            self::DATE_FIELD, self::TIME_FIELD
        );
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $entrenadorId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Elimina clase por ID */
    public function deleteById(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM clases WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}

