<?php
namespace App\Entity;
use App\Database\DatabaseConnection;
use App\Interface\CrudInterface;
use PDO;

class User implements CrudInterface
{
    private int $id;
    private string $email;
    private string $password;
    private string $role; // 'admin' ou 'academic'

    public function __construct(string $email, string $password, string $role = 'academic')
    {
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setRole($role);
    }

    // Getters et setters avec validation
    public function getId(): int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }
    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): void {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) throw new \Exception("Email invalide.");
        $this->email = $email;
    }
    public function getPassword(): string { return $this->password; }
    public function setPassword(string $password): void {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
    public function getRole(): string { return $this->role; }
    public function setRole(string $role): void {
        if (!in_array($role, ['admin', 'academic'])) throw new \Exception("Rôle invalide.");
        $this->role = $role;
    }

    // CRUD
    public function save(): bool {
        $pdo = DatabaseConnection::getConnexion();
        $sql = "INSERT INTO users (email, password, role) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$this->email, $this->password, $this->role]);
    }
    public function findAll(): array {
        $pdo = DatabaseConnection::getConnexion();
        $stmt = $pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function update(): bool {
        $pdo = DatabaseConnection::getConnexion();
        $sql = "UPDATE users SET email = ?, password = ?, role = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$this->email, $this->password, $this->role, $this->id]);
    }
    public function delete(): bool {
        $pdo = DatabaseConnection::getConnexion();
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$this->id]);
    }

    // Méthode d'authentification
    public static function authenticate(string $email, string $password): ?User {
        $pdo = DatabaseConnection::getConnexion();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($userData && password_verify($password, $userData['password'])) {
            $user = new User($userData['email'], $userData['password'], $userData['role']);
            $user->setId($userData['id']);
            return $user;
        }
        return null;
    }
}