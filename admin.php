<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ajouter un nouvel utilisateur
    $new_username = $_POST['new_username'];
    $new_password = $_POST['new_password'];
    $new_role = $_POST['role'];

    // Ici, on devrait enregistrer les utilisateurs dans une base de données
    // ou un fichier pour plus de sécurité. Cet exemple est simplifié.
    echo "Nouvel utilisateur $new_username créé avec le rôle $new_role.";
}
?>
