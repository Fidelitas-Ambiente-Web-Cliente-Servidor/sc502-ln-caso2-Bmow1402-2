<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Solicitud.php';
require_once __DIR__ . '/../models/Taller.php';

class AdminController
{
    private $solicitudModel;
    private $tallerModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->connect();

        $this->solicitudModel = new Solicitud($db);
        $this->tallerModel = new Taller($db);
    }

    public function solicitudes()
    {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            header('Location: index.php?page=login');
            return;
        }
        require __DIR__ . '/../views/admin/solicitudes.php';
    }

    public function getSolicitudesJson()
{
    // ver si el usuario está logueado y es admin
    if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
        echo json_encode(['error' => 'No autorizado']);
        return;
    }
    
    $data = $this->solicitudModel->getPendientes();
    
    if (!$data) {
        $data = [];
    }
    
    header('Content-Type: application/json');
    echo json_encode($data);
}

    public function aprobar()
    {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            return;
        }
        
        $id = $_POST['id'];
        
        $solicitud = $this->solicitudModel->getById($id);
        
        if (!$solicitud) {
            echo json_encode(['success' => false, 'message' => 'Solicitud no encontrada']);
            return;
        }
        
        // validar cupo en tiempo real
        $taller = $this->tallerModel->getById($solicitud['taller_id']);
        
        if($taller['cupo_disponible'] <= 0){
            echo json_encode([
                'success' => false,
                'message' => 'No hay cupos disponibles'
            ]);
            return;
        }
        
        // descontar cupo
        $this->tallerModel->descontarCupo($solicitud['taller_id']);
        
        // aprobar solicitud
        $this->solicitudModel->aprobar($id);
        
        echo json_encode(['success' => true, 'message' => 'Solicitud aprobada']);
    }

    public function rechazar()
    {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            return;
        }
        
        $id = $_POST['id'];
        $this->solicitudModel->rechazar($id);
        
        echo json_encode(['success' => true, 'message' => 'Solicitud rechazada']);
    }
}