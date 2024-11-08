<?php
session_start(); // Assurez-vous que la session est démarrée pour accéder aux variables de session
?>

<link rel="stylesheet" href="/public/styles/styles.css"> 
<link rel="stylesheet" href="/public/styles/mediaQueries.css"> 
<link rel="stylesheet" href="/public/styles/print.css" media="print">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<body>
<?php include 'header.php'; ?>

<section class="contact-section">
    <div class="container">
        <div class="form-container">
            <h2>Nous contacter</h2>
            <p>Nous vous répondrons sous un jour ouvrable.</p>
            
            <form action="/src/controllers/ContactController.php" method="POST">
                <label for="first-name">Prénom</label>
                <input type="text" id="first-name" class="input-field" name="first-name" required>
                
                <label for="last-name">Nom</label>
                <input type="text" id="last-name" class="input-field" name="last-name" required>
                
                <label for="email">Adresse e-mail <span class="required">*</span></label>
                <input type="email" id="email" class="input-field" name="email" required>
                
                <label for="question">Quelle est votre question ? <span class="required">*</span></label>
                <textarea id="question" class="textarea-field" name="question" rows="5" required></textarea>
                
                <input type="submit" class="submit-button" value="ENVOYER">
            </form>

            <?php
            // Vérifier s'il y a un message d'erreur ou de succès et l'afficher
            if (isset($_SESSION['error'])) {
                echo "<div class='error-message'>" . $_SESSION['error'] . "</div>";
                unset($_SESSION['error']); // Supprimer le message après l'affichage
            }

            if (isset($_SESSION['success'])) {
                echo "<div class='success-message'>" . $_SESSION['success'] . "</div>";
                unset($_SESSION['success']); // Supprimer le message après l'affichage
            }
            ?>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
</body>