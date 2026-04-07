<?php

class Solicitud
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function crear($usuarioId, $tallerId)
    {
        // evitar doble inscripción
        $check = "SELECT id FROM solicitudes 
                  WHERE usuario_id = ? 
                  AND taller_id = ? 
                  AND estado IN ('pendiente','aprobada')";

        $stmt = $this->conn->prepare($check);
        $stmt->bind_param("ii", $usuarioId, $tallerId);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            return false;
        }

        $query = "INSERT INTO solicitudes 
                  (usuario_id, taller_id, estado) 
                  VALUES (?, ?, 'pendiente')";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $usuarioId, $tallerId);

        return $stmt->execute();
    }

    // Obtener SOLO solicitudes PENDIENTES (para admin aprobar/rechazar)
    public function getPendientes()
    {
        $query = "SELECT 
                    s.id,
                    u.username,
                    t.nombre AS nombre_taller,
                    s.fecha_solicitud,
                    s.estado
                  FROM solicitudes s
                  INNER JOIN usuarios u ON u.id = s.usuario_id
                  INNER JOIN talleres t ON t.id = s.taller_id
                  WHERE s.estado = 'pendiente'
                  ORDER BY s.fecha_solicitud DESC";

        $result = $this->conn->query($query);
        
        if (!$result) {
            return [];
        }
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        return $data;
    }

    // Obtener TODAS las solicitudes (para admin ver historial)
    // Obtener TODAS las solicitudes (para admin)
    public function getTodas()
    {
        $query = "SELECT 
                    s.id,
                    u.username,
                    t.nombre AS nombre_taller,
                    s.fecha_solicitud,
                    s.estado
                FROM solicitudes s
                INNER JOIN usuarios u ON u.id = s.usuario_id
                INNER JOIN talleres t ON t.id = s.taller_id
                ORDER BY s.fecha_solicitud DESC";

        $result = $this->conn->query($query);
        
        if (!$result) {
            return [];
        }
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        return $data;
    }

// Verificar si un usuario fue rechazado en un taller específico
public function fueRechazado($usuarioId, $tallerId)
{
    $query = "SELECT id FROM solicitudes 
              WHERE usuario_id = ? 
              AND taller_id = ? 
              AND estado = 'rechazada'";

    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("ii", $usuarioId, $tallerId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->num_rows > 0;
}

    // Obtener solicitudes de un usuario específico
    public function getByUsuario($usuarioId)
    {
        $query = "SELECT 
                    s.id,
                    t.nombre AS nombre_taller,
                    s.fecha_solicitud,
                    s.estado
                  FROM solicitudes s
                  INNER JOIN talleres t ON t.id = s.taller_id
                  WHERE s.usuario_id = ?
                  ORDER BY s.fecha_solicitud DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $usuarioId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        return $data;
    }

    public function aprobar($id)
    {
        $query = "UPDATE solicitudes 
                  SET estado='aprobada' 
                  WHERE id=?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    public function rechazar($id)
    {
        $query = "UPDATE solicitudes 
                  SET estado='rechazada' 
                  WHERE id=?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    public function getById($id)
    {
        $query = "SELECT * FROM solicitudes WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}