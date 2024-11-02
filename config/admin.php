<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    // Rediriger vers la page de connexion
    header('Location: /src/views/connexion.php');
    exit();
}

// Vérifier si l'utilisateur est un administrateur
if ($_SESSION['user']['role'] !== 'admin') {
    // Afficher un message d'erreur ou rediriger
    echo "Accès interdit : Vous devez être administrateur pour accéder à cette page.";
    exit();
}
?>
