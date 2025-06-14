<?php declare(strict_types=1);declare(strict_types=1);
namespace App\Controllers\api;

use App\Core\Controller;

class ApiAdministradorController extends Controller
{
    public function dashboard(): void
    {
        if (($_SESSION['rol'] ?? '') !== 'administrador') {
            echo json_encode(['success' => false]);
            return;
        }

        $summary = $this->model('MembresiaModel')->calcularIngresosTotales();

        echo json_encode([
            'success' => true,
            'summary' => $summary      // total, active, expired
        ]);
    }
}


