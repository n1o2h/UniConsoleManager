<?php
include '../Abstruct/Person.php';

class User extends Person
{
    private int $id;
    private string $email;
    private string $password;
    private string  $role;

    public function __construct(int $id, string $nom, string $prenom,  string $email, string $password, string $role)
    {
        parent::__construct($nom, $prenom);
        $this->id = $id;
        $this->email= $email;
        $this->password = $password;
        $this->role = $role;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function toString (): string
    {
        return "ID: ".$this->getId()
            . "\nNOM: " . $this->getNom()
            . "\nPRENOM: " . $this->getPrenom()
            . "\nEMAIL: " . $this->getEmail()
            . "\nPASSWORD: " . $this->getPassword()
            . "\nROLE: " . $this->getRole();

    }
}

$f1 = new User(1, "ait hammad", "nohaila",  "nouhaila@gmail.com", 123456, "Admin");
echo $f1->toString();
