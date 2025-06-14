<?php
namespace App\Models;

use PDO;

class RutinaModel
{
    private PDO $pdo;

    /* columnas reales de la tabla */
    private const COL_ID_TRAINER   = 'entrenador_id';
    private const COL_ID_CLIENTE   = 'usuario_id';          // (por si la usas luego)
    private const COL_DESCRIPCION  = 'descripcion';
    private const COL_EJERCICIO    = 'ejercicio';
    private const COL_SERIES       = 'series';
    private const COL_REPETICIONES = 'repeticiones';
    private const COL_NOMBRE_DIA   = 'nombre_dia';
    private const COL_DIA_SEMANA   = 'dia_semana';

    public function __construct(PDO $pdo) { $this->pdo = $pdo; }

    /** Rutinas de este entrenador */
    public function findByTrainer(int $trainerId): array
    {
        $sql = sprintf(
            'SELECT * FROM rutinas WHERE %s = :id ORDER BY id DESC',
            self::COL_ID_TRAINER
        );
        $st = $this->pdo->prepare($sql);
        $st->execute(['id' => $trainerId]);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Crear rutina */
    public function create(array $d): bool
    {
        $sql = sprintf(
            'INSERT INTO rutinas
              (%1$s, %2$s, %3$s, %4$s, %5$s, %6$s, %7$s)
             VALUES
              (:trainer, :descr, :ej, :se, :re, :nd, :ds)',
            self::COL_ID_TRAINER,
            self::COL_DESCRIPCION,
            self::COL_EJERCICIO,
            self::COL_SERIES,
            self::COL_REPETICIONES,
            self::COL_NOMBRE_DIA,
            self::COL_DIA_SEMANA
        );

        $st = $this->pdo->prepare($sql);
        return $st->execute([
            'trainer' => (int) $d['entrenador_id'],
            'descr'   => trim($d['descripcion']     ?? ''),
            'ej'      => trim($d['ejercicio']       ?? ''),
            'se'      => (int)  ($d['series']       ?? 0),
            're'      => (int)  ($d['repeticiones'] ?? 0),
            'nd'      => trim($d['nombre_dia']      ?? ''),
            'ds'      => trim($d['dia_semana']      ?? ''),
        ]);
    }
}

