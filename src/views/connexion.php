<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Connexion - BagShare</title>
    
    <link rel="stylesheet" href="/bagshare/public/styles/styles.css"> <!-- Lien vers votre feuille de style -->
</head>

<body>
    <section class="connexion-section">
        <!-- Ajout du logo -->
        <div class="logo-container">
            <img src="/bagshare/public/data/images/logo2.png" alt="Logo BagShare" class="logo">
            <span class="logo-text">BagShare</span> <!-- Texte de remplacement pour petit écran -->
        </div>

        <h2>Connexion</h2>

        <!-- Formulaire de connexion -->
        <form method="post" action="../controllers/AuthController.php">
            <div>
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div>
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>

            <!-- Bouton de connexion -->
            <button type="submit">Se connecter</button>
        </form>

        <!-- Bouton retour à l'accueil -->
        <button class="btn-home" onclick="window.location.href='../../public/index.php'">Retour à l'accueil</button>

        <!-- Affichage d'un message d'erreur en cas de problème de connexion -->
        <?php if (isset($_GET['error'])): ?>
            <p class="error-message"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>
    </section>
</body>
</html>
