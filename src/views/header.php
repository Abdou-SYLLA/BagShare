<header>
    <div class="logo">
        <img src="/public/data/images/logo2.png" alt="BagShare"> <!-- Chemin absolu -->
    </div>
    <nav>
        <a href="/bagshare/public/index.php">Acceuil</a> <!-- Chemin absolu -->
        <a href="/bagshare/src/views/annonce.php">Annonces</a> <!-- Chemin absolu -->
        <a href="/bagshare/src/views/about.php">A propos</a> <!-- Chemin absolu -->
        <a href="/bagshare/src/views/contact.php">Nous contacter</a> <!-- Chemin absolu -->

        <?php
        if (isset($_SESSION['user'])) {
            // Si l'utilisateur est connecté, afficher son nom et un bouton de déconnexion
            echo "<a href='#'>" . htmlspecialchars($_SESSION['nom']) . "</a>";
            echo "<a href='/src/controllers/disconnect.php' class=\"btn-secondary\">Déconnexion</a>"; // Chemin absolu
        } else {
            echo "<a href='/src/views/connexion.php' class=\"btn-secondary\">Connexion</a>"; // Chemin absolu
        }
        ?>
    </nav>
</header>
