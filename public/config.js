document.addEventListener('DOMContentLoaded', function() {
    // Sélectionner le premier élément avec la classe 'logo'
    const logo = document.getElementsByClassName('logo')[0];

    // Vérifier si l'élément existe avant d'ajouter l'événement
    if (logo) {
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



