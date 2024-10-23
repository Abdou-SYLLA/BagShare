<header>
    <div class="logo">
        <img src="/public/data/images/logo2.png" alt="BagShare"> <!-- Chemin absolu -->
    </div>
    <nav>
        <?php
        $current_page = basename($_SERVER['PHP_SELF']); // Obtient le nom du fichier PHP en cours
        
        // Définir les liens avec une condition pour la classe 'active'
        ?>
        <a href="/public/index.php" class="<?= $current_page == 'index.php' ? 'active' : '' ?>">Accueil</a> <!-- Chemin absolu -->
        <a href="/src/views/annonce.php" class="<?= $current_page == 'annonce.php' ? 'active' : '' ?>">Annonces</a> <!-- Chemin absolu -->
        <a href="/src/views/about.php" class="<?= $current_page == 'about.php' ? 'active' : '' ?>">A propos</a> <!-- Chemin absolu -->
        <a href="/src/views/contact.php" class="<?= $current_page == 'contact.php' ? 'active' : '' ?>">Nous contacter</a> <!-- Chemin absolu -->

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
