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

    // Récupérer les données du formulaire
    $description = $_POST['description'];
    $depart = $_POST['depart'];
    $arrivee = $_POST['arrivee'];
    $date = $_POST['date'];
    $kilos_disponibles = $_POST['kilos_disponibles'];
    $prix_par_kilo = $_POST['prix_par_kilo'];
    $user = $_SESSION['user']; // L'utilisateur qui ajoute l'annonce

    // Insérer l'annonce dans la base de données
    $stmt = $conn->prepare("INSERT INTO annonces (description, depart, arrivee, date, kilos_disponibles, prix_par_kilo, user) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssids", $description, $depart, $arrivee, $date, $kilos_disponibles, $prix_par_kilo, $user);

    if ($stmt->execute()) {
        echo "Annonce ajoutée avec succès.";
    } else {
        echo "Erreur lors de l'ajout de l'annonce: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
