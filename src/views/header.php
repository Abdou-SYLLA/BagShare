<header>
    <div class="logo">
        <img src="/public/data/images/logo2.png" alt="BagShare">
    </div>
    
    <!-- Bouton menu pour appareils <768px -->
    <button id="menu-toggle" class="menu-icon">&#9776;</button>

    <!-- Menu de navigation principal pour les appareils <768px -->
    <nav id="mobile-menu">
        <?php
        $current_page = basename($_SERVER['PHP_SELF']);
        ?>
        <a href="/public/index.php" class="<?= $current_page == 'index.php' ? 'active' : '' ?>">Accueil</a>
        <a href="/src/views/annonce.php" class="<?= $current_page == 'annonce.php' ? 'active' : '' ?>">Annonces</a>
        <a href="/src/views/about.php" class="<?= $current_page == 'about.php' ? 'active' : '' ?>">À propos</a>
        <a href="/src/views/contact.php" class="<?= $current_page == 'contact.php' ? 'active' : '' ?>">Nous contacter</a>

        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
            <a href="/src/views/account.php" class="<?= $current_page == 'account.php' ? 'active' : '' ?>">Gestion des Comptes</a>
        <?php endif; ?>
    </nav>

    <!-- Liens de connexion et utilisateur, toujours visibles même en mobile -->
    <div class="user-actions">
        <?php if (isset($_SESSION['user'])): ?>
            <a href="/src/views/user.php"><?= htmlspecialchars($_SESSION['user']['nom']); ?></a>
            <a href="/src/controllers/logout.php" class="btn-secondary">Déconnexion</a>
        <?php else: ?>
            <a href="/src/views/connexion.php" class="btn-secondary">Connexion</a>
        <?php endif; ?>
    </div>

    <script src="/public/config.js"></script>
</header>
