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