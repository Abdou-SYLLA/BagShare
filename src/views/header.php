<header>
    <div class="logo">
        <img src="/bagshare/public/data/images/logo2.png" alt="BagShare"> <!-- Chemin absolu -->
    </div>
    <nav>
        <a href="/bagshare/public/index.php">Profile</a> <!-- Chemin absolu -->
        <a href="/bagshare/src/views/about.php">A propos</a> <!-- Chemin absolu -->
        <a href="/bagshare/src/views/contact.php">Nous contacter</a>

        <?php
        session_start();
        if (isset($_SESSION['user'])) {
            echo "<a href='#'>" . htmlspecialchars($_SESSION['nom']) . "</a>";
            echo "<a href='/bagshare/src/controllers/disconnect.php' class=\"btn-secondary\">Déconnexion</a>"; // Chemin absolu
        } else {
            echo "<a href='/bagshare/src/views/connexion.php' class=\"btn-secondary\">Connexion</a>"; // Chemin absolu
        }
        ?>
    </nav>
</header>
