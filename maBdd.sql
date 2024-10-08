/*creer la base de donnee*/
CREATE DATABASE bagshare;
USE bagshare;


/*creation de  la table users */
CREATE TABLE users (
    numero INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    role ENUM('user', 'admin')
);

/* Création de la table annonces */
CREATE TABLE annonces (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    description TEXT,
    depart VARCHAR(100),
    arrivee VARCHAR(100),
    date DATE,
    kilos_disponibles INT,
    prix_par_kilo DECIMAL(10, 2),
    numero INT UNSIGNED,
    FOREIGN KEY (numero) REFERENCES users(numero)
);


/*peupler la table annonces */
INSERT INTO annonces (description, depart, arrivee, date, kilos_disponibles, prix_par_kilo, numero) 
VALUES 
('Voyage vers Italie', 'France', 'Italie', '2024-10-20', 10, 10, 0753320000), 
('Voyage vers France', 'Allemagne', 'France', '2024-11-20', 5, 8, 0652360000), 
('Voyage vers Espagne', 'Bali', 'Espagne', '2024-12-20', 15, 12, 0652360000), 
('Voyage vers Espagne', 'USA', 'Espagne', '2024-12-20', 7, 10, 0753320000);


/*Peupler la table users*/

INSERT INTO users (nom, prenom, numero, role)
VALUES
('Abdou', 'Sylla', 0753320000, 'admin'),
('Ely', 'Sada', 0652360000, 'user');
