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

    public function getTodas()
    {
        $query = "SELECT 
                    s.id,
                    u.username,
                    t.nombre AS taller_nombre,
                    s.fecha_solicitud,
                    s.estado
                  FROM solicitudes s
                  JOIN usuarios u ON u.id = s.usuario_id
                  JOIN talleres t ON t.id = s.taller_id
                  ORDER BY s.fecha_solicitud DESC";

        $result = $this->conn->query($query);

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