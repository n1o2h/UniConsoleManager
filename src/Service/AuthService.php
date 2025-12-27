<?php
namespace App\Service;
use App\Entity\User;

class AuthService
{
    private ?User $currentUser = null;

    public function login(string $email, string $password): bool {
        $user = User::authenticate($email, $password);
        if ($user) {
            $this->currentUser = $user;
            return true;
        }
        return false;
    }

    public function logout(): void {
        $this->currentUser = null;
    }

    public function getCurrentUser(): ?User {
        return $this->currentUser;
    }

    public function isAuthenticated(): bool {
        return $this->currentUser !== null;
    }

    public function hasRole(string $role): bool {
        return $this->currentUser && $this->currentUser->getRole() === $role;
    }
}