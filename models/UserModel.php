<?php
class UserModel {
    private $db;

    public function __construct() {
        $this->db = new mysqli("localhost", "u814339862_admin", "Stafatima104!", "u814339862_produccion");
        if ($this->db->connect_error) {
            die("Error en la conexión: " . $this->db->connect_error);
        }
    }

    public function getUserData($username) {
        $stmt = $this->db->prepare("SELECT * FROM tabla WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getUserGrades($username) {
        $stmt = $this->db->prepare("SELECT * FROM calificaciones WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>