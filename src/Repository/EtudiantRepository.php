<?php
namespace App\Repository;
use App\Database\DatabaseConnection;
use App\Entity\Etudiant;
use PDO;

class EtudiantRepository
{
    public static function findByDepartement(int $deptId): array {
        $pdo = DatabaseConnection::getConnexion();
        $stmt = $pdo->prepare("SELECT * FROM etudiants WHERE departement_id = ?");
        $stmt->execute([$deptId]);
        $etudiants = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $e = new Etudiant($row['nom'], $row['prenom'], $row['email'], $row['cne'], $row['departement_id']);
            $e->setId($row['id']);
            $etudiants[] = $e;
        }
        return $etudiants;
    }
}