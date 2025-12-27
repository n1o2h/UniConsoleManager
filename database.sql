-- Base de données University
CREATE DATABASE IF NOT EXISTS university ;
USE university;

-- 1. Table Users (Pour le login)
CREATE TABLE IF NOT EXISTS users (
                                     id INT AUTO_INCREMENT PRIMARY KEY,
                                     nom VARCHAR(100) NOT NULL,
                                     prenom VARCHAR(100) NOT NULL,
                                     email VARCHAR(150) NOT NULL UNIQUE,
                                     password VARCHAR(255) NOT NULL, -- Sera hashé !
                                     role VARCHAR(50) NOT NULL DEFAULT 'User', -- 'Admin' ou 'User'
                                     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. Table Departments
CREATE TABLE IF NOT EXISTS departments (
                                           id INT AUTO_INCREMENT PRIMARY KEY,
                                           nom VARCHAR(100) NOT NULL,
                                           description TEXT,
                                           created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 3. Table Formateurs
CREATE TABLE IF NOT EXISTS formateurs (
                                          id INT AUTO_INCREMENT PRIMARY KEY,
                                          nom VARCHAR(100) NOT NULL,
                                          prenom VARCHAR(100) NOT NULL,
                                          email VARCHAR(150) NOT NULL UNIQUE,
                                          specialite VARCHAR(100),
                                          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 4. Table Courses (Lié à Department et Formateur)
CREATE TABLE IF NOT EXISTS courses (
                                       id INT AUTO_INCREMENT PRIMARY KEY,
                                       nom VARCHAR(100) NOT NULL,
                                       code VARCHAR(20) NOT NULL UNIQUE, -- Ex: "MATH101"
                                       department_id INT NOT NULL,
                                       formateur_id INT,
                                       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                       FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE CASCADE,
                                       FOREIGN KEY (formateur_id) REFERENCES formateurs(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 5. Table Students (Lié à Department)
CREATE TABLE IF NOT EXISTS students (
                                        id INT AUTO_INCREMENT PRIMARY KEY,
                                        nom VARCHAR(100) NOT NULL,
                                        prenom VARCHAR(100) NOT NULL,
                                        email VARCHAR(150) NOT NULL UNIQUE,
                                        cne VARCHAR(50) NOT NULL UNIQUE,
                                        department_id INT,
                                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                        FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Données de test (Seed)
INSERT IGNORE INTO users (nom, prenom, email, password, role) VALUES
    ('Admin', 'User', 'admin@university.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin'),
    ('User', 'User', 'user@university.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/ige', 'User'); -- password: password


INSERT IGNORE INTO departments (nom, description) VALUES ('Informatique', 'Département de développement et réseaux');
