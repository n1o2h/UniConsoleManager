<?php
class Course {
    private $id;
    private $titre;
    private $volumeHoraire;
    private $departementId;
        public function __construct($id,$titre,$volumeHoraire,$departementId){
        $this->id =$id;
        $this->titre =$titre;
        $this->volumeHoraire =$volumeHoraire;
        $this->departementId=$departementId;
    }
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        if (!is_int($id) || $id <= 0) {
           echo "ID must be a positive.";
        }
        $this->id = $id;
    }

    public function getTitre() {
        return $this->titre;
    }

    public function setTitre($titre) {
        if (!is_string($titre) || trim($titre) == '') {
            echo"Titre must be a not a empty string.";
        }
        $this->titre = trim($titre);
    }

    public function getVolumeHoraire() {
        return $this->volumeHoraire;
    }

    public function setVolumeHoraire($volumeHoraire) {
        if (!is_numeric($volumeHoraire) || $volumeHoraire <= 0) {
            echo "Volume horaire must be a positive number.";
        }
        $this->volumeHoraire = $volumeHoraire;
    }
    public function getDepartementId() {
        return $this->departementId;
    }

    public function setDepartementId($departementId) {
        if (!is_int($departementId) || $departementId <= 0) {
            echo"Departement ID must be a positive integer.";
        }
        $this->departementId = $departementId;
    }
}
?>
