<?php
namespace App\Abstruct;
use App\Exception\ValidationException;

abstract class  Person
{
    protected ?int $id = null;
   protected string $nom;
   protected string $prenom;
   protected string $email;

   public function __construct(string $nom, string $prenom, string $email){
       $this->nom = $nom;
       $this->prenom = $prenom;
       $this->email = $email;
   }

   public function getId(): ?int
    {
        return $this->id;
    }


    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }
    public function getEmail(): string
    {
        return $this->email;
    }


    public function setId(int $id): void
    {
        $this->id = $id;
    }


    public function setNom(string $nom): void
    {
        if (empty($nom)) {
            throw new ValidationException("Le nom ne peut pas être vide.");
        }
        $this->nom = $nom;
    }

    public function setPrenom(string $prenom): void
    {
        if (empty($prenom)) {
            throw new ValidationException("Le prénom ne peut pas être vide.");
        }
        $this->prenom = $prenom;
    }


    public function setEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException("Email invalide.");
        }
        $this->email = $email;
    }
}