<?php
namespace App\Repository;
use App\Database\DatabaseConnection;
use App\Entity\Formateur;
use PDO;

class FormateurRepository
{
    public static function findById(int $id): ?Formateur {
        $pdo = DatabaseConnection::getConnexion();
        $stmt = $pdo->prepare("SELECT * FROM formateurs WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            $f = new Formateur($data['nom'], $data['prenom'], $data['email'], $data['specialite']);
            $f->setId($data['id']);
            return $f;
        }
        return null;
    }

    public static function getCoursesByFormateur(int $formateurId): array {
        $pdo = DatabaseConnection::getConnexion();
        $stmt = $pdo->prepare("SELECT c.* FROM cours c JOIN formateur_cours fc ON c.id = fc.cours_id WHERE fc.formateur_id = ?");
        $stmt->execute([$formateurId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}