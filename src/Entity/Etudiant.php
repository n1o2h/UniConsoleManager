<?php
include '../Entity/User.php';
include  '../Entity/Cour.php';

class Etudiant extends User
{
    private int $CNE;
    //private string $specialite;

    private $cours = [];
    public function __construct(int $id, string $nom, string $prenom, string $email, string $password, string $role,  int $CNE)
    {
        parent::__construct($id, $nom, $prenom, $email, $password, $role);
        $this->CNE = $CNE;
    }

    public function getCNE(): int
    {
        return $this->CNE;
    }

    public function setCNE(int $CNE): void
    {
        $this->CNE = $CNE;
    }
    public function toString (): string
    {
        return "ID: ".$this->getId()
            . "\nNOM: " . $this->getNom()
            . "\nPRENOM: " . $this->getPrenom()
            . "\nEMAIL: " . $this->getEmail()
            . "\nCNE: " . $this->getCNE();

    }
}

$f1 = new Etudiant(1, "ait hammad", "nohaila", "nouhaila@gmail.com", "12345");
echo $f1->toString();
