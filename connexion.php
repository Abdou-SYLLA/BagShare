<?php
session_start();

$users = [
    'admin' => ['password' => 'adminpass', 'role' => 'admin'],
    'user1' => ['password' => 'userpass', 'role' => 'user']
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isset($users[$username]) && $users[$username]['password'] === $password) {
        $_SESSION['user'] = $username;
        $_SESSION['role'] = $users[$username]['role'];

        if ($_SESSION['role'] === 'admin') {
            header('Location: admin.php');
        } else {
            header('Location: index.php');
        }
        exit();
    } else {
        $error = "Identifiants incorrects";
    }
}

include 'header.html';
if (isset($error)) {
    echo "<p style='color: red; text-align:center;'>$error</p>";
}
include 'connexion.html';
include 'footer.html';
?>
