$(document).ready(function() {
    $.ajax({
        url: '/BagShare/src/controllers/AnnonceController.php',
        type: 'POST',
        dataType: 'json',
        data: { action: 'getAnnonces' }, // Envoyer une action pour le contrôleur
        success: function(data) {
            console.log("Données reçues :", data); // Affichez les données dans la console
            const annonceList = $('#annonceList');
            annonceList.empty(); // Vider la liste avant d'ajouter de nouvelles annonces
            
            if (data.length > 0) {
                data.forEach(function(annonce) {
                    let buttons = `<button class="btn-reserver">Réserver maintenant</button>`;
                    
                    // Si l'utilisateur est connecté, ajouter le bouton "Supprimer"
                    if (isUserLoggedIn) {
                        buttons += `<button class="btn-supprimer btn-danger">Supprimer</button>`;
                    }

                    // Ajouter l'annonce avec les boutons
                    annonceList.append(`
                        <div class='annonce'>
                            <h3>Destination: ${annonce.arrivee}</h3>
                            <p>Départ: ${annonce.depart}</p>
                            <p>Kilos disponibles: ${annonce.kilos_disponibles} kg</p>
                            <p>Prix par kilo: ${annonce.prix_par_kilo} €/kg</p>
                            <p>Date: ${annonce.date}</p>
                            <p>Voyageur: ${annonce.nom}</p>
                            <div class="action-buttons">
                                ${buttons}
                            </div>
                        </div>
                    `);
                });

                // Gestion des clics sur les annonces
                $('.annonce').on('click', function() {
                    // Enlever la classe 'clicked' des autres annonces pour ne garder que celle-ci active
                    $('.annonce').removeClass('clicked');
                    $(this).addClass('clicked');
                });

                // Comportement du bouton de réservation
                $('.btn-reserver').on('click', function(e) {
                    e.stopPropagation(); // Empêche le clic sur l'annonce elle-même
                    alert("Vous avez réservé cette annonce !");
                });

                // Comportement du bouton "Supprimer" (s'il existe)
                $('.btn-supprimer').on('click', function(e) {
                    e.stopPropagation(); // Empêche le clic sur l'annonce elle-même
                    alert("Vous avez supprimé cette annonce !");
                    // Ajouter ici le code pour réellement supprimer l'annonce si nécessaire
                });
            } else {
                annonceList.append('<p>Aucune annonce trouvée.</p>');
            }
        },
        error: function(xhr, status, error) {
            $('#annonceList').append('<p>Erreur lors du chargement des annonces.</p>');
        }
    });
});
