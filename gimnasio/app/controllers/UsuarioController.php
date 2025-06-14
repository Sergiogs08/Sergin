<?php declare(strict_types=1);declare(strict_types=1);
// app/controllers/UsuarioController.php
namespace App\Controllers;

use App\Core\Controller;
use Exception;

class UsuarioController extends Controller
{
    private $usuarioModel, $rutinaModel, $reservaModel, $membresiaModel;

    public function __construct()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        if (strtolower($_SESSION['rol'] ?? '') !== 'usuario') {
            header('Location:' . BASE_URL . 'auth/index');
            exit;
        }

        $this->usuarioModel   = $this->model('UsuarioModel');
        $this->rutinaModel    = $this->model('RutinaModel');
        $this->reservaModel   = $this->model('ReservaModel');
        $this->membresiaModel = $this->model('MembresiaModel');
    }

    public function dashboard()
    {
        $uid = (int) $_SESSION['user_id'];
        $usuario         = $this->usuarioModel->findById($uid)       ?? [];
        $currentRoutines = $this->rutinaModel
                               ->findByTrainer((int)$usuario['trainer_id'])
                             ?? [];
        // Obtenemos todas las reservas detalladas y filtramos
        $allReservations  = $this->reservaModel->findAllDetailed() ?? [];
        $reservedClasses  = array_filter($allReservations, function($r) use ($uid) {
            return isset($r['usuario_id'])
                && (int)$r['usuario_id'] === $uid;
        });
        $plans = $this->membresiaModel->findAll() ?? [];

        // GALERÃA...
        $galleryImages = [];
        try {
            $imgDir = realpath(__DIR__ . '/../../public/frontend/assets/img');
            $files  = is_dir($imgDir)
                ? array_diff(scandir($imgDir), ['.','..'])
                : [];
            foreach ($files as $f) {
                if (preg_match('/\.(png|jpe?g|webp)$/i', $f)) {
                    $galleryImages[] = $f;
                    if (count($galleryImages) >= 20) break;
                }
            }
        } catch (Exception $e) {
            $galleryImages = [];
        }

        $this->view(
            'usuario/dashboard',
            compact(
                'usuario',
                'currentRoutines',
                'reservedClasses',
                'plans',
                'galleryImages'
            )
        );
    }

    public function rutinas()
    {
        $uid = (int) $_SESSION['user_id'];
        $usuario         = $this->usuarioModel->findById($uid) ?? [];
        $currentRoutines = $this->rutinaModel
                               ->findByTrainer((int)$usuario['trainer_id'])
                             ?? [];
        $this->view('usuario/rutinas', compact('currentRoutines'));
    }

    public function reservas()
    {
        $uid = (int) $_SESSION['user_id'];
        $allReservations  = $this->reservaModel->findAllDetailed() ?? [];
        $reservedClasses  = array_filter($allReservations, function($r) use ($uid) {
            return isset($r['usuario_id'])
                && (int)$r['usuario_id'] === $uid;
        });
        $this->view('usuario/reservas', compact('reservedClasses'));
    }
}


