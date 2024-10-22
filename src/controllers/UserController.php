<?php
session_start();

require_once '../models/User.php';

$userModel = new User();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Authentification de l'utilisateur
    $authResult = $userModel->authenticate($username, $password);

    if ($authResult === true) {
        // Redirection en fonction du rôle
        if ($_SESSION['role'] == 'admin') {
            header('Location: admin_dashboard.php'); // Page pour l'admin
        } else {
            header('Location: user_dashboard.php'); // Page pour l'utilisateur normal
        }
        exit();
    } else {
        // Redirection vers la page de connexion avec le message d'erreur
        header('Location: html/connexion.html?error=' . urlencode($authResult));
        exit();
    }
}

// Gérer la déconnexion
if (isset($_GET['logout'])) {
    $userModel->logout();
    header('Location: /Bagshare/src/views/connexion.php'); // Redirection après déconnexion
    exit();
}
?>
