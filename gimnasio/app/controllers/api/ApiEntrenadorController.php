<?php declare(strict_types=1);declare(strict_types=1);
namespace App\Controllers\api;

use App\Core\Controller;

class ApiEntrenadorController extends Controller
{
    public function dashboard()
    {
        if (($_SESSION['rol'] ?? '') !== 'entrenador') {
            echo json_encode(['success'=>false]); return;
        }
        $eid = $_SESSION['user_id'];
        $clases = $this->model('ClaseModel')->obtenerClasesPorEntrenador($eid);
        $coment = ['Â¡Excelente clase!', 'Me gustÃ³ la rutina']; // â† pon tu query real
        echo json_encode([
          'success'=>true,
          'upcomingClasses'=>$clases,
          'comments'=>$coment
        ]);
    }
}


