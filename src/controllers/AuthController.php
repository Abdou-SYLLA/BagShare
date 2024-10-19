<?php
session_start();
include_once ('/bagshare/config/config.php');
// Inclure le modèle User
require_once '../models/User.php';

$user = new User();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Authentifier l'utilisateur
    if ($user->authenticate($username, $password)) {
        // Rediriger selon le rôle
        if ($_SESSION['role'] == 'admin') {
            header('Location: ../../public/index.php'); // Redirection admin
        } else {
            header('Location: ../../public/index.php'); // Redirection utilisateur standard
        }
        exit();
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect."; // Erreur d'authentification
    }
}

// Redirection vers la page de connexion avec l'erreur s'il y a lieu
if (isset($error)) {
    header('Location: ../views/connexion.php?error=' . urlencode($error));
    exit();
}
