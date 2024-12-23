<?php
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    // L'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header('Location: /src/views/connexion.php'); // Changez cela par le chemin de votre page de connexion
    exit();
}
?>


<section class="section-ajout">
    <h2 class="section-title">Ajouter une Annonce</h2>
    <form id="annonceForm" class="form-ajout" action="/src/controllers/AnnonceController.php" method="POST">
    <input type="hidden" name="action" value="create">
        <div class="form-group">
            <label for="description" class="form-label">Description :</label>
            <input type="text" id="description" name="description" class="form-input" required>
        </div>
        <div class="form-group">
            <label for="depart" class="form-label">Départ (Pays) :</label>
            <input type="text" id="depart" name="depart" class="form-input" required>
        </div>
        <div class="form-group">
            <label for="ville_depart" class="form-label">Ville de départ :</label>
            <input type="text" id="ville_depart" name="ville_depart" class="form-input" required>
        </div>
        <div class="form-group">
            <label for="arrivee" class="form-label">Arrivée (Pays) :</label>
            <input type="text" id="arrivee" name="arrivee" class="form-input" required>
        </div>
        <div class="form-group">
            <label for="ville_destination" class="form-label">Ville de destination :</label>
            <input type="text" id="ville_destination" name="ville_destination" class="form-input" required>
        </div>
        <div class="form-group">
            <label for="adresse_depot" class="form-label">Adresse de dépôt :</label>
            <input type="text" id="adresse_depot" name="adresse_depot" class="form-input" required>
        </div>
        <div class="form-group">
            <label for="date" class="form-label">Date :</label>
            <input type="date" id="date" name="date" class="form-input" required>
        </div>
        <div class="form-group">
            <label for="kilos_disponibles" class="form-label">Kilos disponibles :</label>
            <input type="number" id="kilos_disponibles" name="kilos_disponibles" class="form-input" required>
        </div>
        <div class="form-group">
            <label for="prix_par_kilo" class="form-label">Prix par kilo (€) :</label>
            <input type="number" step="0.01" id="prix_par_kilo" name="prix_par_kilo" class="form-input" required>
        </div>
        <div class="form-group">
            <label for="numero" class="form-label">Numéro de l'utilisateur :</label>
            <input type="number" id="numero" name="numero" class="form-input" value="<?= $_SESSION['user']['numero'] ?>" required>
        </div>

        <div class="form-group actions">
            <button type="submit" class="btn btn-submit">Ajouter l'annonce</button>
        </div>
    </form>
</section>
