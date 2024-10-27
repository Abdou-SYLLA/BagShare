$(document).ready(function() {
    const pexelsApiKey = 'sOAuszc1UnoCX3r3LWVDZjRYdHEJ1MoyBA6Y7vURmUL7GEQ4b2gGYpSq'; // Remplacez par votre clé API Pexels

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
                    $.ajax({
                        url: `https://api.pexels.com/v1/search?query=${annonce.ville_destination} iconic&per_page=1`,
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
                                    <p>Kilos disponibles: ${annonce.kilos_disponibles} kg</p>
                                    <p>Prix par kilo: ${annonce.prix_par_kilo} €/kg</p>
                                    <p>Date: ${annonce.date}</p>
                                    <p>Depot: ${annonce.adresse_depot}</p>
                                    <p>Voyageur: ${annonce.nom}, Num: ${annonce.numero}</p>
                                    <div class="action-buttons">
                                        <button class="btn-reserver">Réserver maintenant</button>
                                        ${isUserLoggedIn ? `<button class="btn-supprimer" style="display: none;">Supprimer</button>` : ''}
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

    // Utilisez la délégation d'événements pour éviter les répétitions
    $('#annonceList')
        .off('click', '.annonce') // Détache tout événement click précédent
        .on('click', '.annonce', function() {
            $('.annonce').removeClass('clicked');
            $(this).addClass('clicked');
            if (isUserLoggedIn) {
                $(this).find('.btn-supprimer').show();
            }
            $('.annonce').not(this).find('.btn-supprimer').hide();
        });

    $('#annonceList')
        .off('click', '.btn-reserver') // Détache tout événement click précédent
        .on('click', '.btn-reserver', function(e) {
            e.stopPropagation();
            alert("Vous avez réservé cette annonce !");
        });

    $('#annonceList')
        .off('click', '.btn-supprimer') // Détache tout événement click précédent
        .on('click', '.btn-supprimer', function(e) {
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
