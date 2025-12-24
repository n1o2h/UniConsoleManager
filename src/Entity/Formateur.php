<?php
include '../Abstruct/Person.php';

class Formateur extends Person
{
    private int $matricule;
    private string $specialite;

    //private  array  $Cours;
    public function __construct(int $id, string $nom, string $prenom, string $email,  int $matricule, string $specialite)
    {
        parent::__construct($id, $nom, $prenom, $email);
        $this->matricule = $matricule;
        $this->specialite = $specialite;
    }

    public function getMatricule(): int
    {
        return $this->matricule;
    }

    public function setMatricule(int $matricule): void
    {
        $this->matricule = $matricule;
    }

    public function getSpecialite(): string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): void
    {
        $this->specialite = $specialite;
    }

    public function toString (): string
    {
        return "ID: ".$this->getId()
            . "\nNOM: " . $this->getNom()
            . "\nPRENOM: " . $this->getPrenom()
            . "\nEMAIL: " . $this->getEmail()
            . "\nMATRICULE: " . $this->getMatricule()
            . "\nSPECIALITE: " . $this-> getSpecialite();

    }
}

$f1 = new Formateur(1, "ait hammad", "nohaila", "nouhaila@gmail.com", 123456, "Mathematique");
echo $f1->toString();