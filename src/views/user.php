<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs</title>
    <link rel="stylesheet" href="/public/styles/users.css">
</head>
<body>

<section class="container">
    <h2>Ajout d'utilisateurs</h2>
    <form action="/ajouter-utilisateur" method="POST" id="addUserForm">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required>

        <label for="role">Rôle :</label>
        <select id="role" name="role" required>
            <option value="">Sélectionnez un rôle</option>
            <option value="Admin">admin</option>
            <option value="Utilisateur">user</option>
        </select>

        <label for="numero">Numéro de téléphone :</label>
        <input type="tel" id="numero" name="numero" required pattern="[0-9]{10}" placeholder="Ex: 0123456789">

        <button type="submit">Ajouter l'Utilisateur</button>
    </form>
</section>

<!-- Section pour lister les utilisateurs -->
<section class="container">
    <h2>Liste des utilisateurs</h2>
    <table id="userTable" border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Rôle</th>
                <th>Numéro de téléphone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Les utilisateurs récupérés via AJAX seront insérés ici -->
        </tbody>
    </table>
</section>

<!-- Modale pour modifier un utilisateur -->
<div id="editUserModal" style="display: none;">
    <h2>Modifier l'utilisateur</h2>
    <form id="editUserForm">
        <label for="editNom">Nom :</label>
        <input type="text" id="editNom" name="nom" required>

        <label for="editPrenom">Prénom :</label>
        <input type="text" id="editPrenom" name="prenom" required>

        <label for="editRole">Rôle :</label>
        <select id="editRole" name="role" required>
            <option value="Admin">admin</option>
            <option value="Utilisateur">user</option>
        </select>

        <label for="editNumero">Numéro de téléphone :</label>
        <input type="tel" id="editNumero" name="numero" required pattern="[0-9]{10}" placeholder="Ex: 0123456789">

        <button type="submit">Modifier l'Utilisateur</button>
    </form>
</div>

<!-- Inclusion du script externe -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="/public/users.js"></script>

</body>
</html>
