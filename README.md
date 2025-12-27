# Application de Gestion Universitaire (Console PHP 8)

##  Description

Cette application est une application **console** développée en **PHP 8** permettant de gérer les départements, les cours, les formateurs, les étudiants et les utilisateurs d’une université.  
Elle met en pratique la **programmation orientée objet**, la **modélisation UML** et un **CRUD sécurisé via PDO**, en respectant les normes **PSR-4** (autoload) et **PSR-12** (style de code).  

L’accès aux fonctionnalités est protégé par une **authentification** avec gestion de **rôles** :  
- **Administrateur** : gestion complète (CRUD + affectations).  
- **Utilisateur académique** : consultation uniquement.  

---

##  Fonctionnalités principales

### Authentification & rôles
- Connexion par **email / mot de passe** (mot de passe hashé avec `password_hash`).  
- Vérification systématique de l’authentification avant toute action.  
- Gestion des rôles (admin / academic) pour contrôler les accès.  

### Gestion des départements
- US04 : Créer un département.  
- US05 : Modifier un département.  
- US06 : Supprimer un département.  
- US07 : Lister tous les départements.  

### Gestion des cours
- US08 : Créer un cours et l’associer à un département.  
- US09 : Modifier un cours.  
- US10 : Supprimer un cours.  
- US11 : Lister les cours par département.  

### Gestion des formateurs
- US12 : Créer un formateur.  
- US13 : Modifier un formateur.  
- US14 : Supprimer un formateur.  
- US15 : Affecter un formateur à un ou plusieurs cours.  
- US16 : Consulter les cours enseignés par un formateur.  

### Gestion des étudiants
- US17 : Inscrire un étudiant.  
- US18 : Modifier un étudiant.  
- US19 : Supprimer un étudiant.  
- US20 : Affecter un étudiant à un département.  
- US21 : Lister les étudiants par département.  
- US22 : Lister les cours suivis par un étudiant (via son département).  

---

##  Architecture du projet

Arborescence recommandée du dossier `src/` :  
src/
├── Entity/
│ ├── Department.php
│ ├── Cour.php
│ ├── Formateur.php
│ ├── Etudiant.php
│ └── User.php
├── Abstract/
│ └── Person.php
├── Interface/
│ └── CrudInterface.php
├── Repository/
│ ├── DepartmentRepository.php
│ ├── CourRepository.php
│ ├── FormateurRepository.php
│ └── EtudiantRepository.php
├── Service/
│ ├── AuthService.php
│ └── UniversityService.php
├── Exception/
│ └── ValidationException.php
├── Database/
│ └── DatabaseConnection.php
└── index.php


- **Entity** :  
  - Représente les entités métier (User, Etudiant, Formateur, Department, Cour).  
  - Contient les attributs, getters/setters avec validation, méthodes `save()`, `update()`, `delete()`, `findAll()`.  

- **Abstract/Person.php** :  
  - Classe abstraite commune à `Etudiant` et `Formateur` (nom, prénom, email, id).  
  - Montre l’usage de l’**héritage** et de l’**abstraction**.  

- **Interface/CrudInterface.php** :  
  - Définit le contrat `save()`, `findAll()`, `update()`, `delete()` que chaque entité doit implémenter.  

- **Repository** :  
  - Classes dédiées aux accès spécifiques à la base (recherche par id, jointures, filtrages).  

- **Service** :  
  - `AuthService` : gestion de la connexion, du stockage de l’utilisateur courant et des rôles.  
  - `UniversityService` : méthodes de haut niveau (cours par département, cours par formateur, étudiants par département, etc.).  

- **Exception/ValidationException.php** :  
  - Exception personnalisée utilisée pour la validation serveur des entités (messages clairs sans stack trace).  

- **Database/DatabaseConnection.php** :  
  - Connexion PDO unique à la base MySQL (singleton ou classe statique) avec requêtes préparées.  

- **index.php** :  
  - Point d’entrée console.  
  - Affiche le menu, gère les choix de l’utilisateur et appelle les services/entités.  

---

##  Choix techniques & bonnes pratiques

- **POO avancée**  
  - Encapsulation (`private`, `protected`) sur les propriétés.  
  - Getters / setters avec validation métier.  
  - Héritage via la classe abstraite `Person`.  
  - Polymorphisme : traitement uniforme de plusieurs types (ex. plusieurs entités implémentant `CrudInterface`).  

- **Abstraction & interfaces**  
  - Classe abstraite `Person` pour factoriser l’identité (nom, prénom, email).  
  - `CrudInterface` pour uniformiser les opérations CRUD sur toutes les entités.  

- **Sécurité & PDO**  
  - Utilisation de **requêtes préparées** (`prepare` / `execute`) pour éviter les injections SQL.  
  - Mots de passe sécurisés avec `password_hash()` et `password_verify()`.  
  - Vérification du rôle (`hasRole('admin')`, etc.) avant les actions sensibles.  

- **Type hinting**  
  - Types scalaires (`string`, `int`, `bool`, `array`) et types d’objets dans les signatures des méthodes.  
  - Améliore la lisibilité et la robustesse du code.  

- **Exceptions personnalisées**  
  - `ValidationException` levée en cas de données invalides dans les entités.  
  - Gestion par `try/catch` dans `index.php` pour afficher uniquement des messages clairs à l’utilisateur.  

- **Normes & qualité**  
  - Autoload conforme **PSR-4** (via `composer.json`).  
  - Style de code conforme **PSR-12** (indentation, nommage, etc.).  

---

##  Base de données

- Base MySQL / MariaDB.  
- Scripts fournis dans le dossier `sql/` :  
  - `create_tables.sql` : création des tables (users, etudiants, formateurs, departements, cours, tables d’association si besoin).  
  - `seed_data.sql` : jeux de données de test (utilisateur admin, départements, cours, etc.).  

Relations clés :  
- Un **département** possède plusieurs **cours** et plusieurs **étudiants**.  
- Un **formateur** peut enseigner plusieurs **cours** (relation 1‑N ou N‑N selon ton modèle).  
- Un **étudiant** est affecté à un seul département.  

---

##  Installation & exécution

### 1. Prérequis

- PHP 8.x (avec extension PDO/MySQL activée).  
- MySQL .  
- Composer.  

### 2. Récupération du projet
```bash 
git clone <https://github.com/n1o2h/UniConsoleManager>
php index.php;
```






