<?php
    session_start(); // Nécessaire pour accéder aux variables de session
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Annonces</title>
    <link rel="stylesheet" href="/public/styles/styles.css"> <!-- Fichier CSS partagé -->
</head>
<body>
    
<script type="text/javascript">
    var isUserLoggedIn = <?php echo isset($_SESSION['user']) ? 'true' : 'false'; ?>;
</script>

<div class="content-container">
    <!-- Header pour la section Annonces -->
    <header>
        
        <div class="logo">
            <img src="/public/data/images/logo2.png" alt="BagShare"> <!-- Chemin absolu ou relatif -->
        </div>
        <nav>
            <a href="../../public/index.php">Accueil</a> <!-- Chemin absolu ou relatif -->           
            <?php
            if (isset($_SESSION['user'])) {
                echo "<a href=\"#ajouterAnnonce\">Ajouter</a>";
                // Si l'utilisateur est connecté, afficher son nom et un bouton de déconnexion
                echo "<a href='#'>" . htmlspecialchars($_SESSION['nom']) . "</a>";
                echo "<a href='/src/controllers/disconnect.php' class=\"btn-secondary\">Déconnexion</a>";
            } else {
                echo "<a href='/src/views/connexion.php' class=\"btn-secondary\">Connexion</a>";
            }
            ?>
        </nav>
    </header>

    <!-- Section pour afficher les annonces sous forme de cartes -->
    <section class="annonces">
        <h2 class="section-title">Prochains départs</h2> <!-- Titre en h2 centré -->
        <div class="annonce-list" id="annonceList">
            <!-- Les annonces seront ajoutées ici par JavaScript -->
        </div>
    </section>

    <!-- Section pour ajouter une annonce (visible uniquement pour les utilisateurs authentifiés) -->
    <?php
        if (isset($_SESSION['user'])) {
            include_once ('AddAnnonce.php');
        }
    ?>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="../../public/Ajax.js"></script> <!-- Lien vers le fichier JS -->
<?php include 'footer.php'; ?>
</body>
</html>
