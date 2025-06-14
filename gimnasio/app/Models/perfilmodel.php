<?php
namespace App\Models;

use PDO;

class PerfilModel
{
    /**
     * Conexión PDO
     * @var PDO
     */
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Guarda el cuestionario inicial del usuario en la tabla perfiles
     *
     * @param array $data
     * @return bool
     */
    public function crear(array $data)
    {
        $sql = "INSERT INTO perfiles 
                (usuario_id, edad, sexo, objetivo, lesiones) 
                VALUES 
                (:usuario_id, :edad, :sexo, :objetivo, :lesiones)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':usuario_id' => $data['usuario_id'],
            ':edad'       => $data['edad'],
            ':sexo'       => $data['sexo'],
            ':objetivo'   => $data['objetivo'],
            ':lesiones'   => $data['lesiones']
        ]);
    }
}

