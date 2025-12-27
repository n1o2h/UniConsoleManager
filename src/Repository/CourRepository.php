<?php
namespace App\Repository;
use App\Database\DatabaseConnection;
use App\Entity\Cour;
use PDO;

class CourRepository
{
    public static function findByDepartement(int $deptId): array {
        $pdo = DatabaseConnection::getConnexion();
        $stmt = $pdo->prepare("SELECT * FROM cours WHERE departement_id = ?");
        $stmt->execute([$deptId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById(int $id): ?Cour {
        $pdo = DatabaseConnection::getConnexion();
        $stmt = $pdo->prepare("SELECT * FROM cours WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            $cours = new Cour($data['titre'], $data['description'], $data['departement_id']);
            $cours->setId($data['id']);
            return $cours;
        }
        return null;
    }
}