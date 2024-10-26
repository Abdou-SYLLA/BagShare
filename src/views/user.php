<?php
session_start(); // Nécessaire pour accéder aux variables de session
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon compte</title>
    <link rel="stylesheet" href="/public/styles/footer.css">
    <link rel="stylesheet" href="/public/styles/styles.css"> 
    <link rel="stylesheet" href="/public/styles/users.css">
    <link rel="stylesheet" href="/public/styles/header.css">
    
</head>
<body>
<?php include 'header.php'; ?>

<section class="container">
    <h2>Mon Compte</h2>

    <!-- Affichage des informations de l'utilisateur -->
    <div class="user-info">
        <p><strong>Nom :</strong> <?php echo htmlspecialchars($_SESSION['user']['nom']); ?></p>
        <p><strong>Prénom :</strong> <?php echo htmlspecialchars($_SESSION['user']['prenom']); ?></p>
        <p><strong>Numéro de téléphone :</strong> <?php echo htmlspecialchars($_SESSION['user']['numero']); ?></p>
        <p><strong>nom d'utilisateur :</strong> <?php echo htmlspecialchars($_SESSION['user']['username']); ?></p>
        <button id="editUserButton">Modifier mes informations</button>
    </div>
</section>

<!-- Modale pour modifier l'utilisateur -->
<section id="editUserModal" style="display: none;">
    <h2>Modifier l'utilisateur</h2>
    <form id="editUserForm" method="POST" action="controller.php">
        <label for="editNom">Nom :</label>
        <input type="text" id="editNom" name="nom" value="<?php echo htmlspecialchars($_SESSION['user']['nom']); ?>" required>

        <label for="editPrenom">Prénom :</label>
        <input type="text" id="editPrenom" name="prenom" value="<?php echo htmlspecialchars($_SESSION['user']['prenom']); ?>" required>

        <label for="editNumero">Numéro de téléphone :</label>
        <input type="tel" id="editNumero" name="numero" value="<?php echo htmlspecialchars($_SESSION['user']['numero']); ?>" required pattern="[0-9]{10}" placeholder="Ex: 0123456789">

        <label for="editPassword">Mot de passe :</label>
        <input type="password" id="editPassword" name="password" required>

        <label for="editConfirmPassword">Confirmer le mot de passe :</label>
        <input type="password" id="editConfirmPassword" name="confirm_password" required>
        
        <button type="submit" name="action" value="update_user">Enregistrer les modifications</button>
    </form>
</section>

<!-- Inclusion des scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="/public/users.js"></script>

<?php include 'footer.php'; ?>
</body>
</html>
