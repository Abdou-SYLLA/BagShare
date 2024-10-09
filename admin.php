<?php
// Connexion à la base de données
$conn = new mysqli('127.0.0.1', 'root', '12345678', 'bagshare');  // Adapter selon ton environnement

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Création d'un nouvel utilisateur
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_username']) && isset($_POST['new_password'])) {
    $new_username = $_POST['new_username'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);  // Hash du mot de passe
    $role = $_POST['role'];

    $sql = "INSERT INTO users (username, password, role) VALUES ('$new_username', '$new_password', '$role')";

    if ($conn->query($sql) === TRUE) {
        echo "Nouvel utilisateur créé avec succès";
    } else {
        echo "Erreur lors de la création de l'utilisateur : " . $conn->error;
    }
}

// Suppression d'un utilisateur
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user_id'])) {
    $delete_user_id = $_POST['delete_user_id'];

    $sql = "DELETE FROM users WHERE id='$delete_user_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Utilisateur supprimé avec succès";
    } else {
        echo "Erreur lors de la suppression de l'utilisateur : " . $conn->error;
    }
}

// Suppression d'une annonce
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_annonce_id'])) {
    $delete_annonce_id = $_POST['delete_annonce_id'];

    $sql = "DELETE FROM annonces WHERE id='$delete_annonce_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Annonce supprimée avec succès";
    } else {
        echo "Erreur lors de la suppression de l'annonce : " . $conn->error;
    }
}

// Fermeture de la connexion
$conn->close();
?>
