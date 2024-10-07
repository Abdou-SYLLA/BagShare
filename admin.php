<?php
session_start();

// Vérification si l'utilisateur est un admin
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header('Location: connexion.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = $_POST['new_username'];
    $new_password = $_POST['new_password'];
    $new_role = $_POST['role'];

    // Stockage des nouveaux utilisateurs dans la base de données à implémenter
    // Pour l'instant on affiche simplement le nouvel utilisateur créé
    echo "Nouvel utilisateur $new_username créé avec le rôle $new_role.";
}

include 'header.html';
include 'admin.html';
include 'footer.html';
?>
