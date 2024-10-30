$(document).ready(function() {
    const pexelsApiKey = 'sOAuszc1UnoCX3r3LWVDZjRYdHEJ1MoyBA6Y7vURmUL7GEQ4b2gGYpSq';

    $.ajax({
        url: '/src/controllers/AnnonceController.php',
        type: 'POST',
        dataType: 'json',
        data: { action: 'getAnnonces' },
        success: function(data) {
            const annonceList = $('#annonceList');
            annonceList.empty();
            
            if (data.length > 0) {
                data.forEach(function(annonce) {
                    const cityKeyword = annonce.endroit_populaire ? annonce.endroit_populaire : `${annonce.ville_destination} most visited place`;

                    $.ajax({
                        url: `https://api.pexels.com/v1/search?query=${encodeURIComponent(cityKeyword)}&per_page=1`,
                        type: 'GET',
                        headers: {
                            Authorization: pexelsApiKey
                        },
                        success: function(imageData) {
                            const imageUrl = imageData.photos && imageData.photos.length > 0 ? imageData.photos[0].src.medium : 'default-image.jpg';

                            annonceList.append(`
                                <div class='annonce' data-id='${annonce.id}'>
                                    <h3>Destination: ${annonce.arrivee}, ${annonce.ville_destination}</h3>
                                    <img src="${imageUrl}" alt="Image de ${annonce.ville_destination}" class="annonce-image">
                                    <p>Départ: ${annonce.depart}, ${annonce.ville_depart}</p>
                                    <p>Date: ${annonce.date}</p>
                                    
                                    <div class="details" style="display: none;">
                                        <p>Kilos disponibles: ${annonce.kilos_disponibles} kg</p>
                                        <p>Prix par kilo: ${annonce.prix_par_kilo} €/kg</p>
                                        <p>Depot: ${annonce.adresse_depot}</p>
                                        <p>Voyageur: ${annonce.nom}, Num: ${annonce.numero}</p>
                                        <div class="action-buttons">
                                            <button class="btn-reserver">Réserver maintenant</button>
                                            ${isUserLoggedIn ? `<button class="btn-supprimer">Supprimer</button>` : ''}
                                        </div>
                                    </div>
                                </div>
                            `);
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

    // Gestion des clics sur les annonces
    $('#annonceList').on('click', '.annonce', function() {
        const details = $(this).find('.details');
        const isOpen = details.is(':visible');

        $('.details').hide(); // Masquer tous les détails
        $('.annonce').removeClass('clicked'); 

        if (!isOpen) {
            $(this).addClass('clicked'); // Ajouter la classe à l'annonce cliquée
            details.show(); // Afficher les détails de cette annonce
        }
    });

    // Gestion de la réservation
    $('#annonceList').on('click', '.btn-reserver', function(e) {
        e.stopPropagation();
        alert("Vous avez réservé cette annonce !");
    });

    // Gestion de la suppression
    $('#annonceList').on('click', '.btn-supprimer', function(e) {
        e.stopPropagation();
        
        const annonceId = $(this).closest('.annonce').data('id');
        
        if (confirm("Êtes-vous sûr de vouloir supprimer cette annonce ?")) {
            $.ajax({
                url: '/src/controllers/AnnonceController.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'delete',
                    id: annonceId
                },
                success: function(response) {
                    if (response.success) {
                        alert("L'annonce a été supprimée avec succès !");
                        $(`.annonce[data-id="${annonceId}"]`).remove();
                    } else {
                        alert("Erreur lors de la suppression de l'annonce : " + response.error);
                    }
                },
                error: function(xhr, status, error) {
                    alert("Une erreur s'est produite lors de la suppression de l'annonce.");
                }
            });
        }
    });
});
