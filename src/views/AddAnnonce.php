 <!-- Section pour ajouter une annonce (visible uniquement pour les utilisateurs authentifiés) -->
 <section class="section-ajout">
        <h2 class="section-title">Ajouter une Annonce</h2> <!-- Titre en h2 centré -->
        <form id="annonceForm" class="form-ajout">
            <div class="form-group">
                <label for="description" class="form-label">Description :</label>
                <input type="text" id="description" name="description" class="form-input" required>
            </div>
            <div class="form-group">
                <label for="depart" class="form-label">Départ :</label>
                <input type="text" id="depart" name="depart" class="form-input" required>
            </div>
            <div class="form-group">
                <label for="arrivee" class="form-label">Arrivée :</label>
                <input type="text" id="arrivee" name="arrivee" class="form-input" required>
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
                <input type="number" id="prix_par_kilo" name="prix_par_kilo" class="form-input" required>
            </div>
            <div class="form-group actions">
                <button type="submit" class="btn btn-submit">Ajouter l'annonce</button>
            </div>
        </form>
    </section>