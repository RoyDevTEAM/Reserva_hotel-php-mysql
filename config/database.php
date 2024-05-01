<?php
class Database {
    private $host = "localhost";
    private $db_name = "hotel_dba";
    private $username = "root"; // Reemplaza 'tu_usuario' con el nombre de usuario de tu base de datos
    private $password = ""; // Reemplaza 'tu_contraseña' con la contraseña de tu base de datos
    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            $this->conn->set_charset("utf8mb4");
        } catch (Exception $e) {
            echo "Database Error: " . $e->getMessage();
        }

        return $this->conn;
    }
}
