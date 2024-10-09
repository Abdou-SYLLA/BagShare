<section>
    <h2>Créer un utilisateur</h2>
    <form method="post" action="creer_utilisateur.php">
        <div>
            <label for="new_username">Nom d'utilisateur :</label>
            <input type="text" id="new_username" name="new_username" required>
        </div>
        <div>
            <label for="new_password">Mot de passe :</label>
            <input type="password" id="new_password" name="new_password" required>
        </div>
        <div>
            <label for="role">Rôle :</label>
            <select id="role" name="role">
                <option value="user">Utilisateur</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <button type="submit">Créer utilisateur</button>
    </form>
</section>
