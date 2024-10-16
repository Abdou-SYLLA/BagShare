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
                    annonceList.append(`
                        <div class='annonce'>
                            <h3>Destination: ${annonce.arrivee}</h3>
                            <p>Départ: ${annonce.depart}</p>
                            <p>Kilos disponibles: ${annonce.kilos_disponibles} kg</p>
                            <p>Prix par kilo: ${annonce.prix_par_kilo} €/kg</p>
                            <p>Date: ${annonce.date}</p>
                            <p>Voyageur: ${annonce.nom}</p>
                        </div>
                    `);
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
