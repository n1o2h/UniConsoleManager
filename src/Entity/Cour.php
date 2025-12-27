<?php
namespace App\Entity;
use App\Database\DatabaseConnection;
use App\Exception\ValidationException;
use App\Interface\CrudInterface;
use PDO;

class Cour implements CrudInterface
{
    private int $id;
    private string $titre;
    private string $description;
    private int $departementId;

    public function __construct(string $titre, string $description, int $departementId)
    {
        $this->titre = $titre;
        $this->description = $description;
        $this->departementId = $departementId;
    }

    // Getters et setters
    public function getId(): int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }
    public function getTitre(): string { return $this->titre; }
    public function setTitre(string $titre): void { $this->titre = $titre; }
    public function getDescription(): string { return $this->description; }
    public function setDescription(string $description): void { $this->description = $description; }
    public function getDepartementId(): int { return $this->departementId; }
    public function setDepartementId(int $departementId): void { $this->departementId = $departementId; }


    //validation cote serveur
    private function validate(): void
    {
        $errors = [];
        if (trim($this->titre) === '') {
            $errors['titre'] = 'Le titre est obligatoire.';
        }
        if (trim($this->description) === '') {
            $errors['description'] = 'La description est obligatoire.';
        }
        if ($this->departementId === null || $this->departementId <= 0) {
            $errors['departement_id'] = 'Le département est obligatoire.';
        }
        if (!empty($errors)) {
            throw new ValidationException('Les données du cours sont invalides.', $errors);
        }
    }
    // CRUD
    public function save(): bool {
        $this->validate();
        $pdo = DatabaseConnection::getConnexion();
        $sql = "INSERT INTO cours (titre, description, departement_id) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$this->titre, $this->description, $this->departementId]);
    }
    public function findAll(): array {
        $pdo = DatabaseConnection::getConnexion();
        $stmt = $pdo->prepare("SELECT * FROM cours");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function update(): bool {
        $this->validate();
        $pdo = DatabaseConnection::getConnexion();
        $sql = "UPDATE cours SET titre = ?, description = ?, departement_id = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$this->titre, $this->description, $this->departementId, $this->id]);
    }
    public function delete(): bool {
        $this->validate();
        $pdo = DatabaseConnection::getConnexion();
        $sql = "DELETE FROM cours WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$this->id]);
    }
}