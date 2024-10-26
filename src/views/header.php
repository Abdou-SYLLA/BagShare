<header>
    <div class="logo">
        <img src="/public/data/images/logo2.png" alt="BagShare"> <!-- Chemin absolu -->
    </div>
    <nav>
        <?php
        $current_page = basename($_SERVER['PHP_SELF']); // Obtient le nom du fichier PHP en cours
        ?>

        <!-- Liens de navigation principaux -->
        <a href="/public/index.php" class="<?= $current_page == 'index.php' ? 'active' : '' ?>">Accueil</a>
        <a href="/src/views/annonce.php" class="<?= $current_page == 'annonce.php' ? 'active' : '' ?>">Annonces</a>
        <a href="/src/views/about.php" class="<?= $current_page == 'about.php' ? 'active' : '' ?>">A propos</a>
        <a href="/src/views/contact.php" class="<?= $current_page == 'contact.php' ? 'active' : '' ?>">Nous contacter</a>

        <?php
        if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
            // Si l'utilisateur est administrateur, afficher les options de gestion
            echo '<a href="/src/views/account.php" class="' . ($current_page == 'account.php' ? 'active' : '') . '">Gestion des Comptes</a>';
        }

        if (isset($_SESSION['user'])) {
            // Si l'utilisateur est connecté, afficher son nom et un bouton de déconnexion
            echo '<a href="/src/views/user.php">' . htmlspecialchars($_SESSION['user']['nom']) . '</a>';
            echo '<a href="/src/controllers/disconnect.php" class="btn-secondary">Déconnexion</a>';
        } else {
            echo '<a href="/src/views/connexion.php" class="btn-secondary">Connexion</a>';
        }
        ?>
    </nav>
</header>
