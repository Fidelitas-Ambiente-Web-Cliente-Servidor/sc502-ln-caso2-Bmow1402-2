<?php

class Taller
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllDisponibles()
    {
        $query = "SELECT * FROM talleres WHERE cupo_disponible > 0";
        $result = $this->conn->query($query);
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        return $data;
    }

    // Obtener TODOS los talleres (incluyendo sin cupos) para admin
    public function getAll()
    {
        $query = "SELECT * FROM talleres ORDER BY id";
        $result = $this->conn->query($query);
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        return $data;
    }

    public function getById($id)
    {
        $query = "SELECT * FROM talleres WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function descontarCupo($id)
    {
        $query = "UPDATE talleres 
                  SET cupo_disponible = cupo_disponible - 1 
                  WHERE id = ? AND cupo_disponible > 0";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}