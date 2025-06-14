<?php
// app/models/MembresiaModel.php
namespace App\Models;

use PDO;
use PDOException;

class MembresiaModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo) { $this->pdo = $pdo; }

    /** Planes de membresía */
    public function findAll(): array
    {
        return $this->pdo->query('SELECT * FROM membresias')
                         ->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Ingresos globales y por estado
     * @return array ['total'=>float,'active'=>float,'expired'=>float]
     */
    public function calcularIngresosTotales(): array
    {
        $res = ['total'=>0.0,'active'=>0.0,'expired'=>0.0];
        try {
            $sql = "
              SELECT m.estado, SUM(m.precio) suma
              FROM membresias m
              JOIN usuario_membresia um ON um.membresia_id = m.id
              GROUP BY m.estado
            ";
            $rows = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $r) {
                $suma = (float) $r['suma'];
                $res['total'] += $suma;
                ($r['estado']==='activa') ? $res['active']+=$suma : $res['expired']+=$suma;
            }
        } catch (PDOException $e) {
            $fallback = $this->pdo->query(
                'SELECT SUM(m.precio) FROM membresias m JOIN usuario_membresia um ON um.membresia_id = m.id'
            )->fetchColumn();
            $res = ['total'=>(float)$fallback,'active'=>(float)$fallback,'expired'=>0.0];
        }
        return $res;
    }

    /** Elimina plan por ID */
    public function deleteById(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM membresias WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}

