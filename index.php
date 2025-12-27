<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Exception\ValidationException;
use App\Service\AuthService;
use App\Entity\Department;
use App\Entity\Cour;
use App\Entity\Formateur;
use App\Entity\Etudiant;
use App\Entity\User;
use App\Service\UniversityService;
use App\Repository\DepartmentRepository;
use App\Repository\CourRepository;
use App\Repository\FormateurRepository;
use App\Repository\EtudiantRepository;

$auth = new AuthService();

// Fonction utilitaire pour afficher une liste
function displayList(array $items, string $type): void {
    if (empty($items)) {
      echo "Aucun $type trouvé.\n";
            return;
    }
    foreach ($items as $item) {
        if (is_array($item)) {
            print implode(' | ', $item) . "\n";
        } else {
            print $item . "\n";
        }
    }
}

// Fonction pour gérer les départements
function manageDepartements(AuthService $auth): void {
    while (true) {
        echo "\n--- Gestion des Départements ---\n";
        echo "1. Créer\n2. Modifier\n3. Supprimer\n4. Lister\n5. Retour\n";
        $choice = readline("Choix : ");
        switch ($choice) {
            case 1:
                if (!$auth->hasRole('admin')) { echo "Accès refusé.\n"; break; }
                $nom = readline("Nom : ");
                $desc = readline("Description : ");
                try {
                    $dept = new Department($nom, $desc);
                    if ($dept->save())
                        echo "Créé.\n";
                    else
                        echo "Erreur.\n";

                }catch (ValidationException $e ){
                    echo  $e->getMessage();
                }

                break;
            case 2:
                if (!$auth->hasRole('admin')) { echo "Accès refusé.\n"; break; }
                $id = (int)readline("ID à modifier : ");
                $dept = DepartmentRepository::findById($id);
                if (!$dept) { echo "Non trouvé.\n"; break; }
                $dept->setNom(readline("Nouveau nom : "));
                $dept->setDescription(readline("Nouvelle description : "));
                try {
                    if ($dept->update())
                        echo "Modifié.\n" ;
                    else
                        echo "Erreur.\n";

                }catch (ValidationException $e){
                    echo $e->getMessage();
                }

                break;
            case 3:
                if (!$auth->hasRole('admin')) { echo "Accès refusé.\n"; break; }
                $id = (int)readline("ID à supprimer : ");
                $dept = DepartmentRepository::findById($id);
                if (!$dept) { echo "Non trouvé.\n"; break; }
                    if ($dept->delete())
                        echo "Supprimé.\n";
                    else
                        echo "Erreur.\n";
                break;
            case 4:
                $depts = (new Department('', ''))->findAll();
                displayList($depts, 'département');
                break;
            case 5:
                return;
            default:
                echo "Choix invalide.\n";
        }
    }
}

// Fonction pour gérer les cours (US08-US11)
function manageCours(AuthService $auth): void {
    while (true) {
        echo "\n--- Gestion des Cours ---\n";
        echo "1. Créer\n2. Modifier\n3. Supprimer\n4. Lister\n5. Lister par département\n6. Retour\n";
        $choice = readline("Choix : ");
        switch ($choice) {
            case 1:
                if (!$auth->hasRole('admin')) { echo "Accès refusé.\n"; break; }
                $titre = readline("Titre : ");
                $desc = readline("Description : ");
                $deptId = (int)readline("ID Département : ");
                $cours = new Cour($titre, $desc, $deptId);
                try {
                    if ($cours->save())
                        echo "Créé.\n";
                    else
                        echo "Erreur.\n";

                }catch (ValidationException $e){
                    echo $e->getMessage();
                }
                break;
            case 2:
                if (!$auth->hasRole('admin')) { echo "Accès refusé.\n"; break; }
                $id = (int)readline("ID à modifier : ");
                $cours = CourRepository::findById($id);
                if (!$cours) { echo "Non trouvé.\n"; break; }
                $cours->setTitre(readline("Nouveau titre : "));
                $cours->setDescription(readline("Nouvelle description : "));
                $cours->setDepartementId((int)readline("Nouveau ID Département : "));
                try {
                    if ($cours->update())
                        echo "Modifié.\n" ;
                    else
                        echo "Erreur.\n";

                }catch (ValidationException $e){
                    echo $e->getMessage();
                }

                break;
            case 3:
                if (!$auth->hasRole('admin')) { echo "Accès refusé.\n"; break; }
                $id = (int)readline("ID à supprimer : ");
                $cours = CourRepository::findById($id);
                if (!$cours) { echo "Non trouvé.\n"; break; }

                    if ($cours->delete())
                        echo "Supprimé.\n";
                    else
                        echo "Erreur.\n";

                break;
            case 4:
                $cours = (new Cour('', '', 0))->findAll();
                displayList($cours, 'cours');
                break;
            case 5:
                $deptId = (int)readline("ID Département : ");
                $cours = UniversityService::getCoursesByDepartement($deptId);
                displayList($cours, 'cours');
                break;
            case 6:
                return;
            default:
                echo "Choix invalide.\n";
        }
    }
}

// Fonction pour gérer les formateurs
function manageFormateurs(AuthService $auth): void {
    while (true) {
        echo "\n--- Gestion des Formateurs ---\n";
        echo "1. Créer\n2. Modifier\n3. Supprimer\n4. Lister\n5. Affecter à un cours\n6. Lister cours enseignés\n7. Retour\n";
        $choice = readline("Choix : ");
        switch ($choice) {
            case 1:
                if (!$auth->hasRole('admin')) { echo "Accès refusé.\n"; break; }
                $nom = readline("Nom : ");
                $prenom = readline("Prénom : ");
                $email = readline("Email : ");
                $spec = readline("Spécialité : ");
                try {
                    $form = new Formateur($nom, $prenom, $email, $spec);
                    if ($form->save())
                        echo "Créé.\n";
                    else
                        echo "Erreur.\n";
                }catch (ValidationException $e){
                    echo $e->getMessage();
                }
                break;
            case 2:
                if (!$auth->hasRole('admin')) { echo "Accès refusé.\n"; break; }
                $id = (int)readline("ID à modifier : ");
                $form = FormateurRepository::findById($id);
                if (!$form) { echo "Non trouvé.\n"; break; }
                $form->setNom(readline("Nouveau nom : "));
                $form->setPrenom(readline("Nouveau prénom : "));
                $form->setEmail(readline("Nouvel email : "));
                $form->setSpecialite(readline("Nouvelle spécialité : "));
                try {
                    if ($form->update())
                        echo "Modifié.\n" ;
                    else
                        echo "Erreur.\n";

                }catch (ValidationException $e){
                    echo $e->getMessage();
                }

                break;
            case 3:
                if (!$auth->hasRole('admin')) { echo "Accès refusé.\n"; break; }
                $id = (int)readline("ID à supprimer : ");
                $form = FormateurRepository::findById($id);
                if (!$form) { echo "Non trouvé.\n"; break; }
                if ($form->delete())
                    echo "Supprimé.\n";
                else
                    echo "Erreur.\n";
                break;
            case 4:
                $forms = (new Formateur('', '', '', ''))->findAll();
                displayList($forms, 'formateur');
                break;
            case 5:
                if (!$auth->hasRole('admin')) { echo "Accès refusé.\n"; break; }
                $formId = (int)readline("ID Formateur : ");
                $courseId = (int)readline("ID Cours : ");
                $form = FormateurRepository::findById($formId);
                if (!$form) { echo "Formateur non trouvé.\n"; break; }

                    if($form->assignToCourse($courseId))
                        echo "Affecté.\n";
                    else
                        echo "Erreur.\n";
                break;
            case 6:
                $formId = (int)readline("ID Formateur : ");
                $cours = UniversityService::getCoursesByFormateur($formId);
                displayList($cours, 'cours enseigné');
                break;
            case 7:
                return;
            default:
                echo "Choix invalide.\n";
        }
    }
}

// Fonction pour gérer les étudiants
function manageEtudiants(AuthService $auth): void {
    while (true) {
        echo "\n--- Gestion des Étudiants ---\n";
        echo "1. Créer\n2. Modifier\n3. Supprimer\n4. Lister\n5. Affecter à un département\n6. Lister par département\n7. Lister cours suivis\n8. Retour\n";
        $choice = readline("Choix : ");
        switch ($choice) {
            case 1:
                if (!$auth->hasRole('admin')) { echo "Accès refusé.\n"; break; }
                $nom = readline("Nom : ");
                $prenom = readline("Prénom : ");
                $email = readline("Email : ");
                $cne = readline("CNE : ");
                $deptId = (int)readline("ID Département : ");
                try {
                    $etud = new Etudiant($nom, $prenom, $email, $cne, $deptId);
                    if ($etud->save())
                        echo "Créé.\n";
                    else
                        echo "Erreur.\n";
                }catch (ValidationException  $e){
                    echo  $e->getMessage();
                }

                break;
            case 2:
                if (!$auth->hasRole('admin')) { echo "Accès refusé.\n"; break; }
                $id = (int)readline("ID à modifier : ");
                $etuds = (new Etudiant('', '', '', '', null))->findAll();
                $etud = null;
                foreach ($etuds as $e) { if ($e->getId() == $id) { $etud = $e; break; } }
                if (!$etud) { echo "Non trouvé.\n"; break; }
                $etud->setNom(readline("Nouveau nom : "));
                $etud->setPrenom(readline("Nouveau prénom : "));
                $etud->setEmail(readline("Nouvel email : "));
                $etud->setCNE(readline("Nouveau CNE : "));
                $etud->setDepartementId((int)readline("Nouveau ID Département : "));
                try {
                    if ($etud->update())
                        echo "Modifié.\n" ;
                    else
                        echo "Erreur.\n";

                }catch (ValidationException $e){
                    echo $e->getMessage();
                }

                break;
            case 3:
                if (!$auth->hasRole('admin')) { echo "Accès refusé.\n"; break; }
                $id = (int)readline("ID à supprimer : ");
                $etuds = (new Etudiant('', '', '', '', null))->findAll();
                $etud = null;
                foreach ($etuds as $e) { if ($e->getId() == $id) { $etud = $e; break; } }
                if (!$etud) { echo "Non trouvé.\n"; break; }

                    if ($etud->delete())
                        echo "Supprimé.\n";
                    else
                        echo "Erreur.\n";
                break;
            case 4:
                $etuds = (new Etudiant('', '', '', '', null))->findAll();
                displayList($etuds, 'étudiant');
                break;
            case 5:
                if (!$auth->hasRole('admin')) { echo "Accès refusé.\n"; break; }
                $id = (int)readline("ID Étudiant : ");
                $deptId = (int)readline("ID Département : ");
                $etuds = (new Etudiant('', '', '', '', null))->findAll();
                $etud = null;
                foreach ($etuds as $e) { if ($e->getId() == $id) { $etud = $e; break; } }
                if (!$etud) { echo "Non trouvé.\n"; break; }
                $etud->setDepartementId($deptId);
                if ($etud->update())
                    echo "Affecté.\n" ;
                else
                    echo "Erreur.\n";
                break;
            case 6:
                $deptId = (int)readline("ID Département : ");
                $etuds = UniversityService::getEtudiantsByDepartement($deptId);
                displayList($etuds, 'étudiant');
                break;
            case 7:
                //les étudiants suivent tous les cours de leur département
                $id = (int)readline("ID Étudiant : ");
                $etuds = (new Etudiant('', '', '', '', null))->findAll();
                $etud = null;
                foreach ($etuds as $e) { if ($e->getId() == $id) { $etud = $e; break; } }
                if (!$etud || !$etud->getDepartementId()) { echo "Non trouvé ou pas affecté.\n"; break; }
                $cours = UniversityService::getCoursesByDepartement($etud->getDepartementId());
                displayList($cours, 'cours suivi');
                break;
            case 8:
                return;
            default:
                echo "Choix invalide.\n";
        }
    }
}

// Programme principal
echo "Bienvenue dans l'application de gestion universitaire\n";
echo "Veuillez vous connecter  :\n";
$email = readline("Email : ");
$password = readline("Mot de passe : ");

if ($auth->login($email, $password)) {
    echo "Connexion réussie. Rôle : " . $auth->getCurrentUser()->getRole() . "\n";

    // Menu principal
    while (true) {
        echo "\n--- Menu Principal ---\n";
        echo "1. Gérer Départements\n";
        echo "2. Gérer Cours\n";
        echo "3. Gérer Formateurs\n";
        echo "4. Gérer Étudiants\n";
        echo "5. Gérer Utilisateurs (Admin seulement)\n";
        echo "6. Se déconnecter\n";
        $choice = readline("Choix : ");

        switch ($choice) {
            case 1:
                manageDepartements($auth);
                break;
            case 2:
                manageCours($auth);
                break;
            case 3:
                manageFormateurs($auth);
                break;
            case 4:
                manageEtudiants($auth);
                break;
            case 5:
                if (!$auth->hasRole('admin')) { echo "Accès refusé.\n"; break; }
                // Gestion utilisateurs (simplifiée, ajouter CRUD si besoin)
                echo "Gestion utilisateurs non implémentée dans ce menu.\n";
                break;
            case 6:
                $auth->logout();
                echo "Déconnexion.\n";
                exit();
            default:
                echo "Choix invalide.\n";
        }
    }
} else {
    echo "Échec de connexion (US03).\n";
}