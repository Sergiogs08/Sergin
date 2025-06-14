<?php declare(strict_types=1);declare(strict_types=1);
namespace App\Controllers\api;

use App\Core\Controller;

class ApiRecepcionistaController extends Controller
{
    public function dashboard()
    {
        if (($_SESSION['rol'] ?? '') !== 'recepcionista') {
            echo json_encode(['success'=>false]); return;
        }
        $hoy = date('Y-m-d');
        $reservas = $this->model('ReservaModel')->obtenerPorFecha($hoy);
        $usuarios = $this->model('UsuarioModel')->listarTodos();
        echo json_encode([
          'success'=>true,
          'reservations'=>$reservas,
          'users'=>array_column($usuarios,'nombre')
        ]);
    }
}


