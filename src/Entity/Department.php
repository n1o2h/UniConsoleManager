<?php
class DepartementReposetory
{
    private $conn;
    
    public function __construct(PDO $conn){
        $this->conn = $conn;
    }
    public function create(Departement $departement){
        $stmt = $this->conn->prepare("INSERT INTO `departement`(`nom`, `description`) VALUES (?,?)");
        $stmt->execute([$departement->getNom(),$departement->getDescription()]);
        $stmt = null;
    }
    public function findAll(Departement $departement){
        $stmt = $this->conn->prepare("SELECT * FROM departement");
        $stmt->execute();
        $arr = $stmt->fetch();
        if (!$arr) {
            exit('no rows');
        }
        $departement = new Departement($arr['id'], $arr['nom'],$arr['description']);
        return $departement;
    }

    
}
