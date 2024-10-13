
<?php
/*gestion de l'authentification des utilisateurs*/

session_start();

// Connexion à la base de données
$servername = "127.0.0.1";
$username = "root";
$password = "12345678";
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
    $stmt = $conn->prepare("SELECT hashed_password, role, nom FROM account inner JOIN users on (user = numero) WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        // Si un utilisateur est trouvé, lier les résultats
        $stmt->bind_result($hashed_password, $role, $nom);
        $stmt->fetch();


        // Vérifier le mot de passe
        echo "Mot de passe fourni: $password<br>";
        echo "Mot de passe haché récupéré: $hashed_password<br>";
        var_dump(password_verify($password, $hashed_password)); // Affiche true ou false

        if (password_verify($password, $hashed_password)) {
            // Enregistrement des données de session
            $_SESSION['user'] = $username; // Enregistre le nom d'utilisateur
            $_SESSION['role'] = $role; // Enregistre le rôle
            $_SESSION['nom'] = $nom; // Enregistre le nom

            // Redirection en fonction du rôle
            if ($role == 'admin') {
                header('Location: index.php'); // Redirection pour admin
            } else {
                header('Location: index.php'); // Redirection pour utilisateur
            }
            exit();
        } else {
            $error = "Mot de passe incorrect."; // Message d'erreur si le mot de passe est incorrect
        }
    } else {
        $error = "Nom d'utilisateur introuvable."; // Message d'erreur si l'utilisateur n'est pas trouvé
    }

    $stmt->close();
}

// Redirection vers la page de connexion avec l'erreur si applicable
if (isset($error)) {
    header('Location: html/connexion.html?error=' . urlencode($error));
    exit();
}

// Fermer la connexion
$conn->close();

?>
