<?php declare(strict_types=1);declare(strict_types=1);
namespace App\Controllers;

use App\Core\Controller;
use App\Models\UsuarioModel;
use App\Models\ClienteModel;
use App\Models\ClaseModel;
use App\Models\RutinaModel;

class EntrenadorController extends Controller
{
    /* sesiÃ³n â†’ ID del entrenador */
    private const TRAINER_SESSION_KEY = 'user_id';

    /*â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ DASHBOARD â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€*/
    public function dashboard(): void
    {
        $this->onlyTrainer();
        $id = $this->trainerId();

        $u = $this->model('UsuarioModel');
        $c = $this->model('ClienteModel');

        $trainer   = $u->findById($id);
        $clientes  = $c->findByTrainer($id);
        $progresoCliente = $clientes ? rand(40, 90) : 0;   // demo

        $this->view('entrenador/dashboard', compact(
            'trainer', 'clientes', 'progresoCliente'
        ));
    }

    /*â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ CLIENTES â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€*/
    public function clientes(): void
    {
        $this->onlyTrainer();
        $clientes = $this->model('ClienteModel')->findByTrainer($this->trainerId());
        $this->view('entrenador/clientes', compact('clientes'));
    }

    /*â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ RUTINAS â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€*/
    public function rutinas(): void
    {
        $this->onlyTrainer();
        $rutinas = $this->model('RutinaModel')->findByTrainer($this->trainerId());
        $this->view('entrenador/rutinas', compact('rutinas'));
    }

    /** GET â†’ formulario  Â·  POST â†’ guarda rutina */
    public function nuevaRutina(): void
    {
        $this->onlyTrainer();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST + ['entrenador_id' => $this->trainerId()];
            $this->model('RutinaModel')->create($data);
            header('Location:' . BASE_URL . 'entrenador/rutinas'); exit;
        }
        $this->view('entrenador/rutina_form');
    }

    /*â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ CLASES â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€*/
    public function clases(): void
    {
        $this->onlyTrainer();
        $clases = $this->model('ClaseModel')
                       ->obtenerClasesPorEntrenador($this->trainerId());
        $this->view('entrenador/clases', compact('clases'));
    }

    /*â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ Helpers â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€*/
    private function onlyTrainer(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        if (($_SESSION['rol'] ?? '') !== 'entrenador') {
            header('Location:' . BASE_URL . 'auth/index'); exit;
        }
    }

    private function trainerId(): int
    {
        if (!isset($_SESSION[self::TRAINER_SESSION_KEY])) {
            throw new \RuntimeException('ID de entrenador no encontrado en sesiÃ³n');
        }
        return (int) $_SESSION[self::TRAINER_SESSION_KEY];
    }
}


