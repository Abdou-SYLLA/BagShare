$(document).ready(function() {
    // Fonction pour charger la liste des utilisateurs
    function loadUsers() {
        $.ajax({
            url: '/src/controllers/AccountController.php',  // URL du contrôleur PHP
            method: 'GET',  // Méthode HTTP
            data: { action: 'getUserAccounts' },  // Action à envoyer pour récupérer les comptes
            success: function(response) {
                // Convertir la réponse en JSON
                const users = JSON.parse(response);
                let userRows = '';  // Variable pour stocker les lignes HTML

                // Générer une ligne HTML pour chaque utilisateur
                users.forEach(user => {
                    userRows += `
                        <tr>
                            <td>${user.user}</td>
                            <td>${user.nom}</td>
                            <td>${user.prenom}</td>
                            <td>${user.username}</td>
                            <td>
                                <button class="edit-btn" data-id="${user.user}">Modifier</button>
                                <button class="delete-btn" data-id="${user.user}">Supprimer</button>
                            </td>
                        </tr>
                    `;
                });

                // Insérer les lignes dans le tableau
                $('#userAccounts tbody').html(userRows);
            },
            error: function(xhr, status, error) {
                alert('Erreur lors du chargement des utilisateurs : ' + error);
            }
        });
    }

    // Charger la liste des utilisateurs au chargement de la page
    loadUsers();

    // Ouvrir la modale pour éditer un utilisateur
    $(document).on('click', '.editUserBtn', function() {
        const userId = $(this).data('id');  // Récupérer l'ID de l'utilisateur
        $.ajax({
            url: '/src/controllers/AccountController.php',
            method: 'GET',
            data: { action: 'getUser', userId: userId },
            success: function(response) {
                const user = JSON.parse(response);  // Convertir la réponse en JSON
                $('#editUserName').val(user.username);
                $('#editPassword').val('');
                $('#confirmEditPassword').val('');
                $('#editUserModal').fadeIn();  // Afficher la modale d'édition
            }
        });
    });

    // Fermer la modale d'édition
    $('#editUserModal').on('click', function(event) {
        if (event.target.id === 'editUserModal') {
            $('#editUserModal').fadeOut();  // Fermer la modale
        }
    });

    // Supprimer un utilisateur
    $(document).on('click', '.deleteUserBtn', function() {
        const userId = $(this).data('id');  // Récupérer l'ID de l'utilisateur
        
        if (confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?")) {
            $.ajax({
                url: '/src/controllers/AccountController.php',
                method: 'POST',
                data: { action: 'deleteUser', userId: userId },
                success: function(response) {
                    alert(response);  // Message de succès ou d'erreur
                    loadUsers();  // Recharger la liste des utilisateurs après suppression
                },
                error: function(xhr, status, error) {
                    alert('Erreur lors de la suppression de l\'utilisateur : ' + error);
                }
            });
        }
    });

    // Soumettre le formulaire de modification de l'utilisateur
    $('#editUserForm').on('submit', function(event) {
        event.preventDefault();  // Empêcher le rechargement de la page
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
                $('#editUserModal').fadeOut();  // Fermer la modale d'édition
                loadUsers();  // Recharger la liste des utilisateurs après la mise à jour
            },
            error: function(xhr, status, error) {
                alert('Erreur lors de la modification de l\'utilisateur : ' + error);
            }
        });
    });
});
