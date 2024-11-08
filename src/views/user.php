<?php
session_start(); // Démarre la session pour utiliser les variables de session

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    // L'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header('Location: /src/views/connexion.php'); // Changez cela par le chemin de votre page de connexion
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon compte</title>

    <link rel="stylesheet" href="/public/styles/styles.css"> 
    <link rel="stylesheet" href="/public/styles/mediaQueries.css">  
    <link rel="stylesheet" href="/public/styles/print.css" media="print">  
</head>
<body>
<?php include 'header.php'; ?>

<section class="userInfo-container">
    <h1>Mon Compte</h1>

    <!-- Affichage des informations de l'utilisateur -->
    <div class="user-info">
        <p><span class="label">Nom :</span> <?php echo htmlspecialchars($_SESSION['user']['nom']); ?></p>
        <p><span class="label">Prénom :</span> <?php echo htmlspecialchars($_SESSION['user']['prenom']); ?></p>
        <p><span class="label">Numéro de téléphone :</span> <?php echo htmlspecialchars($_SESSION['user']['numero']); ?></p>
        <p><span class="label">Nom d'utilisateur :</span> <?php echo htmlspecialchars($_SESSION['user']['username']); ?></p>
    </div>

</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<?php include 'footer.php'; ?>
</body>
</html>
