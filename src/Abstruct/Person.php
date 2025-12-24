<?php

abstract class  Person
{
   protected string $nom;
   protected string $prenom;

   public function __construct(string $nom, string $prenom){
       $this->nom = $nom;
       $this->prenom = $prenom;
   }
   /*
   public function getId(): int
    {
        return $this->id;
    }
   */

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /*public function getEmail(): string
    {
        return $this->email;
    }*/

    /*public function setId(int $id): void
    {
        $this->id = $id;
    }*/

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    /*public function setEmail(string $email): void
    {
        $this->email = $email;
    }*/
}