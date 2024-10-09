<?php
session_start();

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Préparer et exécuter la requête pour vérifier les identifiants
    $stmt = $conn->prepare("SELECT hashed_password, role, nom FROM account NATURAL JOIN users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password, $role, $nom);
        $stmt->fetch();
            // Affiche les valeurs pour débogage
            echo "Récupéré - Mot de passe haché: $hashed_password, Rôle: $role, Nom: $nom<br>";
        } else {
            echo "Aucun utilisateur trouvé avec ce nom d'utilisateur.<br>";
        }
        
        // Vérifier le mot de passe
        if (password_verify($password, $hashed_password)) {
            // Enregistrement des données de session
            $_SESSION['user'] = $username; // Enregistre le nom d'utilisateur
            $_SESSION['role'] = $role; // Enregistre le rôle
            $_SESSION['nom'] = $nom; // Enregistre le nom

            // Affichage pour débogage
            echo htmlspecialchars($nom) . " : nom, role : " . htmlspecialchars($role);

            // Redirection en fonction du rôle
            if ($role == 'admin') {
                header('Location: index.php'); // Pas d'espace supplémentaire ici
            } else {
                header('Location: index.php'); // Pas d'espace supplémentaire ici
            }
            exit();
        } else {
            $error = "Identifiants incorrects"; // Message d'erreur pour mot de passe incorrect
        }
    } else {
        $error = "Identifiants incorrects"; // Message d'erreur pour utilisateur non trouvé
    }
    $stmt->close();
}

// Inclusion du header HTML
include 'html/header.html';
if (isset($error)) {
    echo "<p style='color: red; text-align:center;'>$error</p>"; // Affichage du message d'erreur
}
include 'html/connexion.html'; // Inclusion du formulaire de connexion
include 'html/footer.html'; // Inclusion du footer

// Fermer la connexion
$conn->close();
?>
