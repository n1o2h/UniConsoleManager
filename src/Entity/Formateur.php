<?php
namespace App\Entity;
use App\Abstruct\Person;
use App\Database\DatabaseConnection;
use App\Exception\ValidationException;
use App\Interface\CrudInterface;
use PDO;

class Formateur extends Person implements CrudInterface
{
    private string $specialite;

    public function __construct(string $nom, string $prenom, string $email, string $specialite)
    {
        parent::__construct($nom, $prenom, $email);
        $this->specialite = $specialite;
    }

    // Getters et setters
    public function getSpecialite(): string { return $this->specialite; }
    public function setSpecialite(string $specialite): void { $this->specialite = $specialite; }

    //validation cote serveur
    private function validate(): void
    {
        $errors = [];

        if (trim($this->nom) === '') {
            $errors['nom'] = 'Le nom est obligatoire.';
        }
        if (trim($this->prenom) === '') {
            $errors['prenom'] = 'Le prénom est obligatoire.';
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email invalide.';
        }
        if (trim($this->specialite) === '') {
            $errors['specialite'] = 'La spécialité est obligatoire.';
        }

        if (!empty($errors)) {
            throw new ValidationException('Les données du formateur sont invalides.', $errors);
        }
    }

    // CRUD
    public function save(): bool {
        $this->validate();
        $pdo = DatabaseConnection::getConnexion();
        $sql = "INSERT INTO formateurs (nom, prenom, email, specialite) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$this->nom, $this->prenom, $this->email, $this->specialite]);
    }
    public function findAll(): array {
        $pdo = DatabaseConnection::getConnexion();
        $stmt = $pdo->prepare("SELECT * FROM formateurs");
        $stmt->execute();
        $formateurs = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $f = new Formateur($row['nom'], $row['prenom'], $row['email'], $row['specialite']);
            $f->setId($row['id']);
            $formateurs[] = $f;
        }
        return $formateurs;
    }
    public function update(): bool {
        $this->validate();
        $pdo = DatabaseConnection::getConnexion();
        $sql = "UPDATE formateurs SET nom = ?, prenom = ?, email = ?, specialite = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$this->nom, $this->prenom, $this->email, $this->specialite, $this->id]);
    }
    public function delete(): bool {
        $this->validate();
        $pdo = DatabaseConnection::getConnexion();
        $sql = "DELETE FROM formateurs WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$this->id]);
    }

    // Méthode pour affecter à un cours
    public function assignToCourse(int $courseId): bool {
        $this->validate();
        $pdo = DatabaseConnection::getConnexion();
        $sql = "INSERT INTO formateur_cours (formateur_id, cours_id) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$this->id, $courseId]);
    }

    public function __toString(): string
    {
        return $this->getId() . ' | ' .
            $this->getNom() . ' ' . $this->getPrenom() . ' | ' .
            $this->getEmail() . ' | ' .
            $this->getSpecialite();
    }
}