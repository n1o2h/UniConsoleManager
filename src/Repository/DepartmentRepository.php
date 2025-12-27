<?php
namespace App\Repository;
use App\Database\DatabaseConnection;
use App\Entity\Department;
use PDO;

class DepartmentRepository
{
    public static function findById(int $id): ?Department {
        $pdo = DatabaseConnection::getConnexion();
        $stmt = $pdo->prepare("SELECT * FROM departements WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            $dept = new Department($data['nom'], $data['description']);
            $dept->setId($data['id']);
            return $dept;
        }
        return null;
    }
}