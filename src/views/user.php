<section class="container">
    <h2>Ajout d'utilisateurs</h2>
    <form action="/ajouter-utilisateur" method="POST">
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