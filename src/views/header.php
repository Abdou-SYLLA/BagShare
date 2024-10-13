<header>
    <div class="logo">
        <img src="data/logo2.png" alt="BagShare">
    </div>
    <nav>
        <a href="index.php">Profile</a>
        <a href="html/About.php">A propos</a>
        <a href="#">Nous contacter</a>
    
    <?php
            session_start();
            if (isset($_SESSION['user'])) {
                // L'utilisateur est connecté
                echo "<a href='#'>" . htmlspecialchars($_SESSION['nom']) . "</a>";
                echo "<a href='deconnexion.php' class=\"btn-secondary\">Déconnexion</a>"; 
            } else {
                // L'utilisateur n'est pas connecté
                echo "<a href=\"html\connexion.html\" class=\"btn-secondary\">Connexion</a>";
            }
            ?>
    </nav>
</header>

