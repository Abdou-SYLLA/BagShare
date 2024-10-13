<link rel="stylesheet" href="/bagshare/public/styles/styles.css"> 
<?php include 'header.php'; ?>
<section class="contact-section">
    <div class="container">
        <div class="header">
            <h1>Nous contacter</h1>
        </div>
        
        <div class="nav-links">
            <a href="#">Conditions générales</a>
            <a href="#">Politique de confidentialité</a>
            <a href="#">Informations sur la livraison et le paiement</a>
            <a href="#">Politique de retour</a>
            <a href="#">Nous contacter</a>
        </div>
        
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
