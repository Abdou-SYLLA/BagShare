<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Connexion - BagShare</title>
    
    <link rel="stylesheet" href="/bagshare/public/styles/styles.css"> 
</head>

<body>
    <section class="connexion-section">
        <!-- Ajout du logo -->
        <div class="logo-container">
            <img src="/bagshare/public/data/images/logo2.png" alt="Logo BagShare" class="logo">
            <span class="logo-text">BagShare</span> <!-- Texte de remplacement pour petit écran -->
        </div>

        <h2>Connexion</h2>
        <form method="post" action="../src/controllers/AuthController.php">
            <div>
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div>
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Se connecter</button>
        </form>
        <button class="btn-home" onclick="window.location.href='../../public/index.php'">Retour à l'accueil</button>
    </section>
</body>

</html>
