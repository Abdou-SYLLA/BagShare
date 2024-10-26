$(document).ready(function() {
    const pexelsApiKey = 'sOAuszc1UnoCX3r3LWVDZjRYdHEJ1MoyBA6Y7vURmUL7GEQ4b2gGYpSq'; // Remplacez par votre clé API Pexels

    $.ajax({
        url: '/src/controllers/AnnonceController.php',
        type: 'POST',
        dataType: 'json',
        data: { action: 'getAnnonces' },
        success: function(data) {
            console.log("Données reçues :", data);
            const annonceList = $('#annonceList');
            annonceList.empty();
            
            if (data.length > 0) {
                data.forEach(function(annonce) {
                    // Appel à l'API de Pexels pour récupérer une image de la ville de destination
                    $.ajax({
                        url: `https://api.pexels.com/v1/search?query=${annonce.ville_destination}  iconic spot&per_page=1`,
                        type: 'GET',
                        headers: {
                            Authorization: pexelsApiKey
                        },
                        success: function(imageData) {
                            // Récupération de l'image ou d'une image par défaut si non trouvée
                            const imageUrl = imageData.photos && imageData.photos.length > 0 ? imageData.photos[0].src.medium : 'default-image.jpg';

                            // Construction de l'élément HTML pour l'annonce avec l'image
                            annonceList.append(`
                                <div class='annonce'>
                                    <h3>Destination: ${annonce.arrivee} / ${annonce.ville_destination}</h3>
                                    <img src="${imageUrl}" alt="Image de ${annonce.ville_destination}" class="annonce-image">
                                    <p>Départ: ${annonce.depart} / ${annonce.ville_depart}</p>
                                    <p>Kilos disponibles: ${annonce.kilos_disponibles} kg</p>
                                    <p>Prix par kilo: ${annonce.prix_par_kilo} €/kg</p>
                                    <p>Date: ${annonce.date}</p>
                                    <p>Depot: ${annonce.adresse_depot}</p>
                                    <p>Voyageur: ${annonce.nom}</p>
                                    <div class="action-buttons">
                                        <button class="btn-reserver">Réserver maintenant</button>
                                        ${isUserLoggedIn ? `<button class="btn-supprimer" style="display: none;">Supprimer</button>` : ''}
                                    </div>
                                </div>
                            `);

                            // Configuration des comportements pour les boutons
                            setupButtons();
                        },
                        error: function() {
                            console.error("Erreur lors du chargement de l'image pour", annonce.ville_destination);
                        }
                    });
                });
            } else {
                annonceList.append('<p>Aucune annonce trouvée.</p>');
            }
        },
        error: function(xhr, status, error) {
            $('#annonceList').append('<p>Erreur lors du chargement des annonces.' + error + '</p>');
        }
    });

    function setupButtons() {
        $('.annonce').on('click', function() {
            $('.annonce').removeClass('clicked');
            $(this).addClass('clicked');
            if (isUserLoggedIn) {
                $(this).find('.btn-supprimer').show();
            }
            $('.annonce').not(this).find('.btn-supprimer').hide();
        });

        $('.btn-reserver').on('click', function(e) {
            e.stopPropagation();
            alert("Vous avez réservé cette annonce !");
        });

        $('.btn-supprimer').on('click', function(e) {
            e.stopPropagation();
            alert("Vous avez supprimé cette annonce !");
            // Code pour supprimer l'annonce peut être ajouté ici
        });
    }
});
