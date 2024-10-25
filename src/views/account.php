<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Comptes utilisateurs</title>
    <link rel="stylesheet" href="/public/styles/account.css">
    <link rel="stylesheet" href="/public/styles/header.css">
    <link rel="stylesheet" href="/public/styles/footer.css">
</head>
<body>

<?php include 'header.php' ?>

<section class="User-Account">
    <h2>Créer un compte utilisateur</h2>
    <form action="controller.php" method="POST">
        <label for="user">Numéro utilisateur :</label>
        <input type="text" id="user" name="user" required>

        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Créer l'utilisateur</button>
    </form>
</section>


<!-- Section pour lister les comptes -->
<section class="container">
    <h2>Liste des comptes</h2>
    <table id="userAccounts" border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Nom d'utilisateur</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Les comptes récupérés via AJAX seront insérés ici -->
        </tbody>
    </table>
</section>

<!-- Modale pour modifier un utilisateur -->
<section id="editUserModal" style="display: none;">
    <h2>Modifier le compte de l'utilisateur</h2>
    <form id="editUserForm">
        <label for="editUserName">Nom d'utilisateur :</label>
        <input type="text" id="editUserName" name="editUserName" required>

        <label for="editPassword">Mot de passe :</label>
        <input type="password" id="editPassword" name="editPassword" required>

        <label for="confirmEditPassword">Confirmer le mot de passe :</label>
        <input type="password" id="confirmEditPassword" name="confirmEditPassword" required>

        <button type="submit">Modifier le compte</button>
    </form>
</section>


<!-- Inclusion du script externe -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="/public/accounts.js"></script>

</body>
</html>
