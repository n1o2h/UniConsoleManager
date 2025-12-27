<?php
namespace App\Entity;
use App\Database\DatabaseConnection;
use App\Exception\ValidationException;
use App\Interface\CrudInterface;
use PDO;

class Department implements CrudInterface
{
    private int $id;
    private string $nom;
    private string $description;

    public function __construct(string $nom, string $description)
    {
        $this->nom = $nom;
        $this->description = $description;
    }

    // Getters et setters
    public function getId(): int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }
    public function getNom(): string { return $this->nom; }
    public function setNom(string $nom): void { $this->nom = $nom; }
    public function getDescription(): string { return $this->description; }
    public function setDescription(string $description): void { $this->description = $description; }

    //validation cote serveur
    private function validate(): void
    {
        $errors = [];

        if (trim($this->nom) === '') {
            $errors['nom'] = 'Le nom est obligatoire.';
        }
        if (trim($this->description) === '') {
            $errors['description'] = 'La description est obligatoire.';
        }

        if (!empty($errors)) {
            throw new ValidationException('Les données du département sont invalides.', $errors);
        }
    }
    // CRUD
    public function save(): bool {
        $this->validate();
        $pdo = DatabaseConnection::getConnexion();
        $sql = "INSERT INTO departements (nom, description) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$this->nom, $this->description]);
    }
    public function findAll(): array {
        $pdo = DatabaseConnection::getConnexion();
        $stmt = $pdo->prepare("SELECT * FROM departements");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function update(): bool {
        $this->validate();
        $pdo = DatabaseConnection::getConnexion();
        $sql = "UPDATE departements SET nom = ?, description = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$this->nom, $this->description, $this->id]);
    }
    public function delete(): bool {
        $this->validate();
        $pdo = DatabaseConnection::getConnexion();
        $sql = "DELETE FROM departements WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$this->id]);
    }
}