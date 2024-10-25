$(document).ready(function() {
    // Charger la liste des utilisateurs
    function loadUsers() {
        $.ajax({
            url: '/src/controllers/AccountController.php',
            method: 'GET',
            data: { action: 'getUserAccounts' },
            success: function(response) {
                $('#userAccounts tbody').html(response);
            }
        });
    }
    
    // Charger la liste des utilisateurs au chargement de la page
    loadUsers();

    // Ouvrir la modale pour éditer un utilisateur
    $(document).on('click', '.editUserBtn', function() {
        const userId = $(this).data('id');
        $.ajax({
            url: '/src/controllers/AccountController.php',
            method: 'GET',
            data: { action: 'getUser', userId: userId },
            success: function(response) {
                const user = JSON.parse(response);
                $('#editUserName').val(user.username);
                $('#editPassword').val('');
                $('#confirmEditPassword').val('');
                $('#editUserModal').fadeIn();
            }
        });
    });

    // Fermer la modale
    $('#editUserModal').on('click', function(event) {
        if (event.target.id === 'editUserModal') {
            $('#editUserModal').fadeOut();
        }
    });

    // Soumettre le formulaire de modification de l'utilisateur
    $('#editUserForm').on('submit', function(event) {
        event.preventDefault();
        const formData = {
            action: 'updateUser',
            username: $('#editUserName').val(),
            password: $('#editPassword').val(),
            confirmPassword: $('#confirmEditPassword').val()
        };

        $.ajax({
            url: '/src/controllers/AccountController.php',
            method: 'POST',
            data: formData,
            success: function(response) {
                alert('Utilisateur modifié avec succès');
                $('#editUserModal').fadeOut();
                loadUsers();
            }
        });
    });
});
