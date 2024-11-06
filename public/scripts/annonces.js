$(document).ready(function(){
    const pixabayApiKey = '46937646-4d391177768650b34e8785a7d'; // Remplacez par votre clé Pixabay
    $.ajax({
        url: '/src/controllers/AnnonceController.php',
        type: 'POST',
        dataType: 'json',
        data: { action: 'getAnnonces' },
        success: function(data) {
            const annonceList = $('#annonceList');
            annonceList.empty();

            if (Array.isArray(data) && data.length > 0) { // Vérifie que 'data' est bien un tableau non vide
                data.forEach(function(annonce) {
                    // Combine la ville de destination et l'endroit populaire dans un seul mot-clé pour la recherche d'image
                    const cityKeyword = annonce.endroit_populaire 
                        ? `${annonce.ville_destination} ${annonce.endroit_populaire}` 
                        : `${annonce.ville_destination} most visited place`;

                    // Requête API Pixabay pour l'image
                    $.ajax({
                        url: `https://pixabay.com/api/?key=${pixabayApiKey}&q=${encodeURIComponent(cityKeyword)}&image_type=photo&per_page=3`,
                        type: 'GET',
                        success: function(imageData) {
                            // Utiliser la première image parmi les résultats
                            const imageUrl = imageData.hits && imageData.hits.length > 0 
                                ? imageData.hits[0].webformatURL 
                                : 'default-image.jpg';
                            
                            annonceList.append(`
                                <div class='annonce' data-id='${annonce.id}'>
                                    <h3>Destination: ${annonce.arrivee}, ${annonce.ville_destination}</h3>
                                    <img src="${imageUrl}" alt="Image de ${annonce.ville_destination}" class="annonce-image">
                                    <p>Départ: ${annonce.depart}, ${annonce.ville_depart}</p>
                                    <p>Date: ${annonce.date}</p>
                                    <div class="details" style="display: none;">
                                        <p>Kilos disponibles: ${annonce.kilos_disponibles}kg</p>
                                        <p>Prix par kilo: ${annonce.prix_par_kilo}€/kg</p>
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
                }); // Fin du forEach
            } else {
                annonceList.append('<p>Aucune annonce trouvée.</p>');
            }
        },
        error: function(xhr, status, error) {
            $('#annonceList').append('<p>Erreur lors du chargement des annonces. ' + error + '</p>');
        }
    });

    $('#annonceList').on('click', '.annonce', function() {
        const details = $(this).find('.details');
        const isOpen = details.is(':visible');
        $('.details').hide();
        $('.annonce').removeClass('clicked');
        if (!isOpen) {
            $(this).addClass('clicked');
            details.show();
        }
    });

    $('#annonceList').on('click', '.btn-reserver', function(e) {
        e.stopPropagation();
        alert("Vous avez réservé cette annonce !");
    });

    $('#annonceList').on('click', '.btn-supprimer', function(e) {
        e.stopPropagation();
        const annonceId = $(this).closest('.annonce').data('id');
        if (confirm("Êtes-vous sûr de vouloir supprimer cette annonce ?")) {
            $.ajax({
                url: '/src/controllers/AnnonceController.php',
                type: 'POST',
                dataType: 'json',
                data: { action: 'delete', id: annonceId },
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
