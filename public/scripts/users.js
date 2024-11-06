$(document).ready(function() {
    // Ouvre la modal d'édition de l'utilisateur
    $('#editUserButton').on('click', function() {
        $('#editUserModal').fadeIn();
    });

    // Ferme la modal lorsque l'utilisateur clique en dehors de celle-ci
    $(window).on('click', function(event) {
        if (event.target.id === 'editUserModal') {
            $('#editUserModal').fadeOut();
        }
    });

    // Soumission du formulaire d'édition de l'utilisateur
    $('#editUserForm').on('submit', function(event) {
        event.preventDefault();
        
        // Validation des mots de passe
        const password = $('#editPassword').val();
        const confirmPassword = $('#editConfirmPassword').val();
        if (password !== confirmPassword) {
            alert('Les mots de passe ne correspondent pas.');
            return;
        }

        // Données du formulaire à envoyer
        const formData = {
            action: 'update_user',
            nom: $('#editNom').val(),
            prenom: $('#editPrenom').val(),
            numero: $('#editNumero').val(),
            password: password
        };

        // Requête AJAX pour envoyer les données au serveur
        $.ajax({
            url: '/src/controllers/AccountController.php',
            method: 'POST',
            data: formData,
            success: function(response) {
                alert('Informations modifiées avec succès.');
                $('#editUserModal').fadeOut();
                location.reload(); // Recharge la page pour afficher les changements
            },
            error: function() {
                alert('Erreur lors de la modification des informations.');
            }
        });
    });
});
