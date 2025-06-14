<?php declare(strict_types=1);declare(strict_types=1);
namespace App\Controllers;

use App\Core\Controller;
use App\Models\UsuarioModel;
use App\Models\ClaseModel;
use App\Models\MembresiaModel;

class AdministradorController extends Controller
{
    /*â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ PANEL â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€*/
    public function dashboard(): void
    {
        $this->onlyAdmin();

        /** @var UsuarioModel $u */
        /** @var ClaseModel   $c */
        /** @var MembresiaModel $m */
        $u = $this->model('UsuarioModel');
        $c = $this->model('ClaseModel');
        $m = $this->model('MembresiaModel');

        /*â”€â”€ KPIs â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€*/
        $totalUsuarios       = $u->countAll();
        $clasesProgramadas   = $c->countAll();
        $entrenadoresActivos = $u->countByRole('entrenador');
        $ingresos            = $m->calcularIngresosTotales()['total'];

        /*â”€â”€ Listas â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€*/
        $usuariosRecientes = $u->findRecent(5);
        $clasesProximas    = $c->findUpcoming(5);

        /*â”€â”€ GrÃ¡fico (altas por mes) â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€*/
        $raw = $u->countPerMonth(12);          // ['YYYY-MM'=>n,â€¦]
        $usuariosPorMes = [
            'labels' => array_keys($raw),
            'data'   => array_values($raw)
        ];

        /*â”€â”€ Render â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€*/
        $this->view('admin/dashboard', compact(
            'totalUsuarios',
            'clasesProgramadas',
            'entrenadoresActivos',
            'ingresos',
            'usuariosRecientes',
            'clasesProximas',
            'usuariosPorMes'
        ));
    }

    /*â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ USUARIOS â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€*/
    public function usuarios(): void
    {
        $this->onlyAdmin();
        $usuarios = $this->model('UsuarioModel')->findAll();
        $this->view('admin/usuarios', ['usuarios' => $usuarios]);
    }

    public function eliminarUsuario(): void
    {
        $this->onlyAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model('UsuarioModel')->deleteById((int) $_POST['id']);
        }
        header('Location:' . BASE_URL . 'administrador/usuarios'); exit;
    }

    /*â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ ENTRENADORES â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€*/
    public function entrenadores(): void
    {
        $this->onlyAdmin();
        $entrenadores = $this->model('UsuarioModel')->findByRole('entrenador');
        $this->view('admin/entrenadores', ['entrenadores' => $entrenadores]);
    }

    /*â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ MEMBRESÃAS â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€*/
    public function membresias(): void
    {
        $this->onlyAdmin();
        $membresias = $this->model('MembresiaModel')->findAll();
        $this->view('admin/membresias', ['membresias' => $membresias]);
    }

    /*â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ CLASES â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€*/
    public function clases(): void
    {
        $this->onlyAdmin();
        $clases = $this->model('ClaseModel')->findAll();
        $this->view('admin/clases', ['clases' => $clases]);
    }

    public function eliminarClase(): void
    {
        $this->onlyAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model('ClaseModel')->deleteById((int) $_POST['id']);
        }
        header('Location:' . BASE_URL . 'administrador/clases'); exit;
    }

    /*â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ Helper â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€*/
    private function onlyAdmin(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        if (($_SESSION['rol'] ?? '') !== 'administrador') {
            header('Location:' . BASE_URL . 'auth/index'); exit;
        }
    }
}


