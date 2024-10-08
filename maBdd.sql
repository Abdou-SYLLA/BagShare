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
