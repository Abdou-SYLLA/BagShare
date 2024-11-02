<?php
session_start(); // Démarre la session pour utiliser les variables de session

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    // L'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header('Location: /src/views/connexion.php'); // Changez cela par le chemin de votre page de connexion
    exit();
}

// Si l'utilisateur est connecté et admin, continuer avec la logique de la page
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon compte</title>

    <link rel="stylesheet" href="/public/styles/styles.css"> 
    <link rel="stylesheet" href="/public/styles/mediaQueries.css">  
    <link rel="stylesheet" href="/public/styles/users.css">   
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
<section  class="container" id="editUserModal" style="display: none;">
    <h2>Modifier le Compte</h2>
    <form id="editUserForm" method="POST">
        <div class="editable-field">
            <label for="editNom">Nom :</label>
            <input type="text" id="editNom" name="editNom" required >
            <button type="button" class="edit-field-btn" onclick="toggleEdit('editNom')">Modifier</button>
        </div>

        <div class="editable-field">
            <label for="editPrenom">Prénom :</label>
            <input type="text" id="editPrenom" name="editPrenom" required >
            <button type="button" class="edit-field-btn" onclick="toggleEdit('editPrenom')">Modifier</button>
        </div>

        <div class="editable-field">
            <label for="editPassword">Nouveau Mot de passe :</label>
            <input type="password" id="editPassword" name="editPassword" required >

            <label for="validatePassword">Confimation :</label>
            <input type="password" id="editPassword" name="editPassword" required >

            <button type="button" class="edit-field-btn" onclick="toggleEdit('editPassword')">Modifier</button>
        </div>

        <button type="submit" name="action" value="update">Enregistrer les Modifications</button>
    </form>
</section>


<!-- Inclusion des scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="/public/scripts/users.js"></script>

</body>
</html>
