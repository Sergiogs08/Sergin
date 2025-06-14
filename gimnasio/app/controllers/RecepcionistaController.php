<?php declare(strict_types=1);declare(strict_types=1);
namespace App\Controllers;

use App\Core\Controller;
use App\Models\UsuarioModel;
use App\Models\ClaseModel;
use App\Models\ReservaModel;
use App\Models\MembresiaModel;

class RecepcionistaController extends Controller
{
    /*â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ DASHBOARD â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€*/
    public function dashboard(): void
    {
        /** @var UsuarioModel   $u */
        /** @var ClaseModel     $c */
        /** @var ReservaModel   $r */
        /** @var MembresiaModel $m */
        $u = $this->model('UsuarioModel');
        $c = $this->model('ClaseModel');
        $r = $this->model('ReservaModel');
        $m = $this->model('MembresiaModel');

        /* listados que usa la vista */
        $users       = $u->findAllWithTarifa();   // â† incluye 'tarifa'
        $classes     = $c->findUpcoming(999);
        $reservas    = $r->findAllDetailed();
        $memberships = $m->findAll();

        $this->view('recepcionista/dashboard', compact(
            'users','classes','reservas','memberships'
        ));
    }

    /*â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ USUARIOS â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€*/
    public function usuarios(): void
    {
        $users = $this->model('UsuarioModel')->findAllWithTarifa();
        $this->view('recepcionista/usuarios', compact('users'));
    }

    /** GET â†’ formulario | POST â†’ alta */
    public function nuevoUsuario(): void
    {
        $membresias = $this->model('MembresiaModel')->findAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model('UsuarioModel')->createWithTarifa($_POST);
            header('Location:' . BASE_URL . 'recepcionista/usuarios'); exit;
        }
        $this->view('recepcionista/usuario_form', compact('membresias'));
    }

    /*â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ CLASES â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€*/
    public function clases(): void
    {
        $classes = $this->model('ClaseModel')->findUpcoming(999);
        $this->view('recepcionista/clases', compact('classes'));
    }

    /*â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ RESERVAS â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€*/
    public function reservas(): void
    {
        $reservas = $this->model('ReservaModel')->findAllDetailed();
        $this->view('recepcionista/reservas', compact('reservas'));
    }

    /*â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ TARIFAS â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€*/
    public function tarifas(): void
    {
        $membresias = $this->model('MembresiaModel')->findAll();
        $this->view('recepcionista/tarifas', compact('membresias'));
    }
}


