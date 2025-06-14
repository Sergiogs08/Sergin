<?php declare(strict_types=1);declare(strict_types=1);
namespace App\Controllers\api;

use App\Core\Controller;

class ApiUsuarioController extends Controller
{
    public function dashboard()
    {
        if (($_SESSION['rol'] ?? '') !== 'usuario') {
            echo json_encode(['success'=>false,'error'=>'not-auth']); return;
        }
        $uid = (int)$_SESSION['user_id'];

        $usuario  = $this->model('UsuarioModel')->obtenerPorId($uid);
        $rutina   = $this->model('RutinaModel')->obtenerRutinaActiva($uid);
        $reservas = $this->model('ReservaModel')->listarPorUsuario($uid);

        echo json_encode([
            'success'=>true,
            'user'=>[
                'name'=>$usuario['nombre'],
                'routine'=>$rutina['descripcion'] ?? '',
                'classes'=>array_column($reservas,'titulo')
            ]
        ]);
    }
}


