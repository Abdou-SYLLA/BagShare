document.addEventListener('DOMContentLoaded', function() {
    // Sélectionner le premier élément avec la classe 'logo'
    const logo = document.getElementsByClassName('logo')[0];

    // Vérifier si l'élément existe avant d'ajouter l'événement
    if (logo) {
        logo.style.cursor = 'pointer';
        // Ajouter un événement de clic
        logo.addEventListener('click', function() {
            // Rediriger vers la page index
            window.location.href = '/public/index.php';
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    menuToggle.addEventListener('click', function () {
        mobileMenu.classList.toggle('visible');
    });
});

$(document).ready(function() {
    // Charger le texte des avantages
    $.ajax({
        url: '/src/controllers/AdvantagesText.php',
        method: 'GET',
        success: function(data) {
            // Vider le conteneur avant d'ajouter du contenu
            $('#advantages-text').empty();

            if (Array.isArray(data)) {
                data.forEach(function(avantage) {
                    $('#advantages-text').append('<a>' + avantage.texte + '</a>');
                });
            } 
        },
        error: function() {
            console.error("Erreur lors de la récupération des avantages.");
        }
    });
});


// Charger les images du viewer
$(document).ready(function() {
    let images = []; // Stocker les images récupérées
    let currentIndex = 0; // Index de l'image actuellement affichée

    // Charger les images du viewer
    $.ajax({
        url: '/src/controllers/IMGViewerController.php',
        method: 'GET',
        success: function(data) {
            images = data; // Enregistrer les images
            if (images.length > 0) {
                displayImage(currentIndex); // Afficher la première image
            }
        },
        error: function() {
            console.error("Erreur lors du chargement des images.");
        }
    });

    // Fonction pour afficher l'image actuelle
    function displayImage(index) {
        $('#current-image').attr('src', images[index].src);
        $('#current-image').attr('alt', images[index].alt);
    }

    // Bouton suivant
    $('#next-btn').click(function() {
        currentIndex = (currentIndex + 1) % images.length; // Passer à l'image suivante
        displayImage(currentIndex);
    });

    // Bouton précédent
    $('#prev-btn').click(function() {
        currentIndex = (currentIndex - 1 + images.length) % images.length; // Passer à l'image précédente
        displayImage(currentIndex);
    });
});



