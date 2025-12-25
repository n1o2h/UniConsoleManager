<?php
class DatabaseConnection {
    private $host = "localhost";
    private $dbname = "univercité";
    private $user = "root";
    private $password = "";
    private $conn;

    public function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8",
                $this->user,
                $this->password
            );

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "adnan connected";
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>
