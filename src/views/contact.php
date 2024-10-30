<?php
    session_start(); // Nécessaire pour accéder aux variables de session
?>

<link rel="stylesheet" href="/public/styles/footer.css"> 
<link rel="stylesheet" href="/public/styles/header.css">
<link rel="stylesheet" href="/public/styles/styles.css"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<body>
<?php include 'header.php'; ?>

<section class="contact-section">
    <div class="container">
        <div class="form-container">
            <h2>Nous contacter</h2>
            <p>Nous vous répondrons sous un jour ouvrable.</p>
            
            <form action="/submit_contact_form" method="POST">
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
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
</body>