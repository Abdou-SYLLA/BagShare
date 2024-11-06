document.addEventListener('DOMContentLoaded', function() {
    const logo = document.getElementsByClassName('logo')[0];
    if (logo) {
        logo.style.cursor = 'pointer';
        logo.addEventListener('click', function() {
            window.location.href = '/public/index.php';
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    
    menuToggle.addEventListener('click', function() {
        mobileMenu.classList.toggle('visible');
    });
});

$(document).ready(function() {
    $.ajax({
        url: '/src/controllers/AdvantagesText.php',
        method: 'GET',
        success: function(data) {
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

$(document).ready(function() {
    let images = [];
    let currentIndex = 0;

    $.ajax({
        url: '/src/controllers/IMGViewerController.php',
        method: 'GET',
        success: function(data) {
            images = data;
            if (images.length > 0) {
                displayImage(currentIndex);
            }
        },
        error: function() {
            console.error("Erreur lors du chargement des images.");
        }
    });

    function displayImage(index) {
        $('#current-image').attr('src', images[index].src);
        $('#current-image').attr('alt', images[index].alt);
    }

    $('#next-btn').click(function() {
        currentIndex = (currentIndex + 1) % images.length;
        displayImage(currentIndex);
    });

    $('#prev-btn').click(function() {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        displayImage(currentIndex);
    });
});
