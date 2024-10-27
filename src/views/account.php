<?php
    session_start(); // Démarre la session pour utiliser les variables de session
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs et Comptes</title>
    <link rel="stylesheet" href="/public/styles/styles.css">
    <link rel="stylesheet" href="/public/styles/header.css">
    <link rel="stylesheet" href="/public/styles/account.css">
</head>
<body>

<?php include 'header.php'; ?> <!-- Inclusion du header -->

<section class="container">
    <h2>Créer un Compte Utilisateur</h2>
    <form action="../controllers/AccountController.php" method="POST" id="addUserForm">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required>

        <label for="role">Rôle :</label>
        <select id="role" name="role" required>
            <option value="">Sélectionnez un rôle</option>
            <option value="admin">Admin</option>
            <option value="user">Utilisateur</option>
        </select>

        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required>

        <label for="numero">Numero :</label>
        <input type="tel" id="numero" name="numero" required pattern="[0-9]{10}" placeholder="Ex: 0123456789">

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" name="action" value="create">Ajouter le Compte</button>
    </form>
</section>

<section class="container">
    <h2>Liste des comptes Utilisateurs</h2>
    <table id="userTable" border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Rôle</th>
                <th>Nom d'utilisateur</th>
                <th>Numero</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Les comptes récupérés via AJAX seront insérés ici -->
        </tbody>
    </table>
</section>

<!-- Modale pour modifier les informations d'un utilisateur individuellement -->
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
            <label for="editRole">Rôle :</label>
            <select id="editRole" name="editRole" required >
                <option value="admin">admin</option>
                <option value="user">user</option>
            </select>
            <button type="button" class="edit-field-btn" onclick="toggleEdit('editRole')">Modifier</button>
        </div>

        <div class="editable-field">
            <label for="editUsername">Nom d'utilisateur :</label>
            <input type="text" id="editUsername" name="editUsername" required >
            <button type="button" class="edit-field-btn" onclick="toggleEdit('editUsername')">Modifier</button>
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
<script src="/public/accounts.js"></script>

<script>
// Fonction pour basculer entre l'édition et la lecture seule pour chaque champ
function toggleEdit(fieldId) {
    const field = document.getElementById(fieldId);
    if (field.hasAttribute('readonly') || field.hasAttribute('disabled')) {
        field.removeAttribute('readonly');
        field.removeAttribute('disabled');
    } else {
        field.setAttribute(field.tagName === 'SELECT' ? 'disabled' : 'readonly', true);
    }
}
</script>

</body>
</html>
