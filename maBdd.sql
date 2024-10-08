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

/*creation de  la table annonces */
CREATE TABLE annonces (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    description TEXT,
    depart VARCHAR(100),
    arrivee VARCHAR(100),
    date DATE
);

/*Ajout de collonnes manquantes*/
ALTER TABLE annonces
ADD COLUMN kilos_disponibles INT,
ADD COLUMN prix_par_kilo DECIMAL(10, 2);


/*peupler la table annonces */
INSERT INTO annonces (description, depart, arrivee, date, kilos_disponibles, prix_par_kilo) VALUES 
('Voyage vers Italie', 'France', 'Italie', '2024-10-20', 10, 10), 
('Voyage vers France', 'Allemagne', 'France', '2024-11-20', 5, 8), 
('Voyage vers Espagne', 'Bali', 'Espagne', '2024-12-20', 15, 12), 
('Voyage vers Espagne', 'USA', 'Espagne', '2024-12-20', 7, 10);

/*Peupler la table users*/

INSERT INTO users (nom, prenom, numero, role)
VALUES
('Abdou', 'Sylla', 0753320000, 'admin'),
('Ely', 'Sada', 0652360000, 'user');
