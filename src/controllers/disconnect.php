<?php
session_start(); // Démarre la session

// Vérifie si l'utilisateur est connecté
if (isset($_SESSION['user'])) {
    // Détruire toutes les sessions
    $_SESSION = array(); // Efface les variables de session
    session_destroy(); // Détruit la session
}

// Redirige vers la page de connexion ou la page d'accueil
header('Location: /bagshare/public/index.php'); // Rediriger vers la page de connexion
exit();
?>
