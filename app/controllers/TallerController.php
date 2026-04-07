<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Taller.php';
require_once __DIR__ . '/../models/Solicitud.php';

class TallerController
{
    private $tallerModel;
    private $solicitudModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->connect();
        $this->tallerModel = new Taller($db);
        $this->solicitudModel = new Solicitud($db);
    }

    public function index()
    {
        if (!isset($_SESSION['id'])) {
            header('Location: index.php?page=login');
            return;
        }
        require __DIR__ . '/../views/taller/listado.php';
    }
    
    public function getTalleresJson()
{
    if (!isset($_SESSION['id'])) {
        echo json_encode([]);
        return;
    }
    
    $usuarioId = $_SESSION['id'];
    $talleres = $this->tallerModel->getAllDisponibles();
    
    // Verificar si el usuario fue rechazado en cada taller
    foreach ($talleres as &$taller) {
        $taller['fue_rechazado'] = $this->solicitudModel->fueRechazado($usuarioId, $taller['id']);
    }
    
    header('Content-Type: application/json');
    echo json_encode($talleres);
}

public function getMisSolicitudesJson()
{
    if (!isset($_SESSION['id'])) {
        echo json_encode([]);
        return;
    }
    
    $usuarioId = $_SESSION['id'];
    $solicitudes = $this->solicitudModel->getByUsuario($usuarioId);
    
    header('Content-Type: application/json');
    echo json_encode($solicitudes);
}
    
    public function solicitar()
    {
        if (!isset($_SESSION['id'])) {
            echo json_encode(['success' => false, 'error' => 'Debes iniciar sesión']);
            return;
        }

        $tallerId = $_POST['taller_id'];
        $usuarioId = $_SESSION['id'];

        $result = $this->solicitudModel->crear($usuarioId, $tallerId);

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Ya solicitaste este taller o ya estás inscrito']);
        }
    }
}