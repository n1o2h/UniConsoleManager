<?php
namespace App\Entity;
use App\Abstruct\Person;
use App\Database\DatabaseConnection;
use App\Exception\ValidationException;
use App\Interface\CrudInterface;
use PDO;

class Etudiant extends Person implements CrudInterface
{
    private string $CNE;
    private ?int $departementId;

    public function __construct(string $nom, string $prenom, string $email, string $CNE, ?int $departementId = null)
    {
        parent::__construct($nom, $prenom, $email);
        $this->CNE = $CNE;
        $this->departementId = $departementId;
    }

    // Getters et setters
    public function getCNE(): string { return $this->CNE; }
    public function setCNE(string $CNE): void { $this->CNE = $CNE; }
    public function getDepartementId(): ?int { return $this->departementId; }
    public function setDepartementId(?int $deptId): void { $this->departementId = $deptId; }


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
        if (trim($this->CNE) === '') {
            $errors['cne'] = 'Le CNE est obligatoire.';
        }

        if (!empty($errors)) {
            throw new ValidationException('Les données de l’étudiant sont invalides.', $errors);
        }
    }
    // CRUD
    public function save(): bool {
        $this->validate();
        $pdo = DatabaseConnection::getConnexion();
        $sql = "INSERT INTO etudiants (nom, prenom, email, cne, departement_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$this->nom, $this->prenom, $this->email, $this->CNE, $this->departementId]);
    }
    public function findAll(): array {
        $pdo = DatabaseConnection::getConnexion();
        $stmt = $pdo->prepare("SELECT * FROM etudiants");
        $stmt->execute();
        $etudiants = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $e = new Etudiant($row['nom'], $row['prenom'], $row['email'], $row['cne'], $row['departement_id']);
            $e->setId($row['id']);
            $etudiants[] = $e;
        }
        return $etudiants;
    }
    public function update(): bool {
        $this->validate();
        $pdo = DatabaseConnection::getConnexion();
        $sql = "UPDATE etudiants SET nom = ?, prenom = ?, email = ?, cne = ?, departement_id = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$this->nom, $this->prenom, $this->email, $this->CNE, $this->departementId, $this->id]);
    }
    public function delete(): bool {
        $this->validate();
        $pdo = DatabaseConnection::getConnexion();
        $sql = "DELETE FROM etudiants WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$this->id]);
    }

    public function __toString(): string
    {
        return $this->getId() . ' | ' .
            $this->getNom() . ' ' . $this->getPrenom() . ' | ' .
            $this->getEmail() . ' | ' .
            $this->getDepartementId() . ' | ' .
            $this->getCNE();
    }
}