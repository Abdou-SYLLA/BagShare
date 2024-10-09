/*creer la base de donnee*/
CREATE DATABASE bagshare;
USE bagshare;

/*creation de la table users */
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


/* Création de la table account */
CREATE TABLE account (
    user INT UNSIGNED,
    username VARCHAR(255) NOT NULL,
    hashed_password VARCHAR(255) NOT NULL,
    PRIMARY KEY (username),
    FOREIGN KEY (user) REFERENCES users(numero)
);

DELIMITER //

/* Ajout d'un trigger pour vérifier les contraintes sur username */
CREATE TRIGGER username_constraints
BEFORE INSERT ON account
FOR EACH ROW
BEGIN
    IF LENGTH(NEW.username) < 12 OR NEW.username NOT REGEXP '[0-9]' OR NEW.username NOT REGEXP '[A-Za-z]' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Username must be at least 12 characters long and contain both letters and numbers.';
    END IF;
END;
//

/* Trigger pour vérifier les nouveaux mots de passe */
CREATE TRIGGER before_insert_account
BEFORE INSERT ON account
FOR EACH ROW
BEGIN
  IF LENGTH(NEW.hashed_password) < 12 OR
     NEW.hashed_password NOT REGEXP '[A-Z]' OR
     NEW.hashed_password NOT REGEXP '[0-9]' OR
     NEW.hashed_password NOT REGEXP '[^a-zA-Z0-9]' THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Le mot de passe doit contenir au moins 12 caractères, une majuscule, un chiffre et un caractère spécial.';
  END IF;
  SET NEW.hashed_password = SHA2(CONCAT(NEW.user, NEW.hashed_password), 256);
END;
//

DELIMITER ;


/* Peupler la table annonces */
INSERT INTO annonces (description, depart, arrivee, date, kilos_disponibles, prix_par_kilo, numero) 
VALUES 
('Voyage vers Italie', 'France', 'Italie', '2024-10-20', 10, 10, 0753320000), 
('Voyage vers France', 'Allemagne', 'France', '2024-11-20', 5, 8, 0652360000), 
('Voyage vers Espagne', 'Bali', 'Espagne', '2024-12-20', 15, 12, 0652360000), 
('Voyage vers Espagne', 'USA', 'Espagne', '2024-12-20', 7, 10, 0753320000);

/* Peupler la table users */
INSERT INTO users (nom, prenom, numero, role)
VALUES
('Abdou', 'Sylla', 0753320000, 'admin'),
('Ely', 'Sada', 0652360000, 'user');

/*Creation de compte */
INSERT INTO account (user, username, password, hashed_password)
VALUES (
    0753320000,
    'usernameExemple123',
    SHA2(CONCAT(0753320000, 'MotDePasseExemple1!'), 256)
);



    <?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bagshare";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Informations de l'utilisateur
$user = 0753320000; // Numéro de l'utilisateur
$username = 'usernameExemple123';
$password = 'MotDePasseExemple1!'; // Mot de passe clair
$hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hachage du mot de passe

// Étape 1 : Vérifier si l'utilisateur existe dans `users`
$stmt = $conn->prepare("SELECT numero FROM users WHERE numero = ?");
$stmt->bind_param("i", $user);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 0) {
    // L'utilisateur n'existe pas, insérer dans `users`
    $stmt->close();
    $stmt = $conn->prepare("INSERT INTO users (numero) VALUES (?)");
    $stmt->bind_param("i", $user);
    $stmt->execute();
}

$stmt->close();

// Étape 2 : Insérer les informations de l'utilisateur dans `account`
$stmt = $conn->prepare("INSERT INTO account (user, username, hashed_password) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $user, $username, $hashed_password);

if ($stmt->execute()) {
    echo "Utilisateur ajouté avec succès.";
} else {
    echo "Erreur lors de l'ajout de l'utilisateur: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>