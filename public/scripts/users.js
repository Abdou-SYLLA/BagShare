$(document).ready(function() {
    // Afficher la modale d'édition des informations de l'utilisateur
    $('#editUserButton').on('click', function() {
        $('#editUserModal').fadeIn();  // Affiche la modale
    });

    // Fermer la modale si l'utilisateur clique en dehors du formulaire
    $(window).on('click', function(event) {
        if (event.target.id === 'editUserModal') {
            $('#editUserModal').fadeOut();  // Masque la modale
        }
    });

    // Soumettre le formulaire de modification des informations utilisateur
    $('#editUserForm').on('submit', function(event) {
        event.preventDefault();  // Empêche le rechargement de la page

        // Vérification que les mots de passe correspondent
        const password = $('#editPassword').val();
        const confirmPassword = $('#editConfirmPassword').val();
        if (password !== confirmPassword) {
            alert('Les mots de passe ne correspondent pas.');
            return;
        }

        // Préparation des données du formulaire
        const formData = {
            action: 'update_user',
            nom: $('#editNom').val(),
            prenom: $('#editPrenom').val(),
            numero: $('#editNumero').val(),
            password: password
        };

        // Envoi des données au serveur
        $.ajax({
            url: '/src/controllers/AccountController.php',  // URL du contrôleur PHP pour la mise à jour
            method: 'POST',
            data: formData,
            success: function(response) {
                alert('Informations modifiées avec succès.');
                $('#editUserModal').fadeOut();  // Masque la modale après modification
                location.reload();  // Recharge la page pour mettre à jour les informations
            },
            error: function() {
                alert('Erreur lors de la modification des informations.');
            }
        });
    });
});
