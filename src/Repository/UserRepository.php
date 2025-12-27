<?php
namespace App\Repository;
use App\Database\DatabaseConnection;
use App\Entity\User;
use PDO;

class UserRepository
{
    public static function findById(int $id): ?User {
        $pdo = DatabaseConnection::getConnexion();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            $user = new User($data['email'], $data['password'], $data['role']);
            $user->setId($data['id']);
            return $user;
        }
        return null;
    }
}