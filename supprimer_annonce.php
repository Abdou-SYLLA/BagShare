<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: connexion.php'); // Rediriger vers la page de connexion si non connecté
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bagshare";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connexion échouée: " . $conn->connect_error);
    }

    // Récupérer l'ID de l'annonce à supprimer
    $id = $_POST['id'];

    // Supprimer l'annonce de la base de données
    $stmt = $conn->prepare("DELETE FROM annonces WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Annonce supprimée avec succès.";
    } else {
        echo "Erreur lors de la suppression de l'annonce: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
