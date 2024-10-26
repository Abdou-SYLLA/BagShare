$(document).ready(function() {
    // Fonction pour charger la liste des comptes utilisateurs
    function loadAccounts() {
        $.ajax({
            url: '/src/controllers/AccountController.php',
            type: 'POST',
            dataType: 'json',
            data: { action: 'getUserAccounts' },
            success: function(data) {
                console.log("Données reçues :", data);
                $('#userTable tbody').empty();

                if (data.length > 0) {
                    data.forEach(account => {
                        $('#userTable tbody').append(`
                            <tr>
                                <td>${account.nom}</td>
                                <td>${account.prenom}</td>
                                <td>${account.role}</td>
                                <td>${account.username}</td>
                                <td>${account.numero}</td>
                                <td>
                                    <button class="editAccountBtn" data-id="${account.user}">Modifier</button>
                                    <button class="deleteAccountBtn" data-id="${account.user}">Supprimer</button>
                                </td>
                            </tr>
                        `);
                    });
                } else {
                    console.log("Aucun compte trouvé.");
                }
            },
            error: function(xhr, status, error) {
                console.error("Erreur lors du chargement des comptes :", status, error);
                alert('Erreur lors du chargement des comptes.');
            }
        });
    }

    // Charger les comptes au démarrage
    loadAccounts();

    // Ouvrir la modale de modification pour un compte spécifique
    $(document).on('click', '.editAccountBtn', function() {
        const accountId = $(this).data('id');
        $.ajax({
            url: '/src/controllers/AccountController.php',
            type: 'POST',
            data: { action: 'getUser', userId: accountId },
            dataType: 'json',
            success: function(account) {
                // Remplir les champs de la modale avec les données récupérées
                $('#editNom').val(account.nom);
                $('#editPrenom').val(account.prenom);
                $('#editRole').val(account.role);
                $('#editUsername').val(account.username);
                $('#editPassword').val('');
                $('#editUserModal').fadeIn(); // Affiche le modal
                $('#editUserForm').data('id', accountId);  // Enregistre l'ID du compte dans le formulaire pour l'utiliser lors de la soumission
    
                // Faire défiler la page vers le modal
                $('html, body').animate({
                    scrollTop: $('#editUserModal').offset().top
                }, 500); // 500 est la durée de l'animation en millisecondes
            },
            error: function() {
                alert('Erreur lors de la récupération des informations du compte.');
            }
        });
    });
    

    // Ferme le modal lorsque l'utilisateur clique à l'extérieur
    $('#editUserModal').on('click', function(event) {
        if (event.target.id === 'editUserModal') {
            $('#editUserModal').fadeOut(); 
        }
    });

    // Soumettre les modifications du compte
    $('#editUserForm').on('submit', function(event) {
        event.preventDefault();

        // Préparation des données pour la mise à jour
        const formData = {
            action: 'updateAccount',
            userId: $(this).data('id'), // Récupérer l'ID du compte depuis les données du formulaire
            nom: $('#editNom').val(),
            prenom: $('#editPrenom').val(),
            role: $('#editRole').val(),
            username: $('#editUsername').val(),
            password: $('#editPassword').val()
        };

        // Envoi de la requête de mise à jour
        $.ajax({
            url: '/src/controllers/AccountController.php',
            type: 'POST',
            data: formData,
            success: function() {
                alert('Compte mis à jour avec succès.');
                $('#editUserModal').fadeOut();
                loadAccounts(); // Recharge les comptes mis à jour
            },
            error: function() {
                alert('Erreur lors de la mise à jour du compte.');
            }
        });
    });

    // Suppression d'un compte
    $(document).on('click', '.deleteAccountBtn', function() {
        const accountId = $(this).data('id');
        if (confirm("Voulez-vous vraiment supprimer ce compte ?")) {
            $.ajax({
                url: '/src/controllers/AccountController.php',
                type: 'POST',
                data: { action: 'deleteUser', userId: accountId },
                success: function(response) {
                    alert(response);
                    loadAccounts(); // Recharge les comptes après suppression
                },
                error: function() {
                    alert('Erreur lors de la suppression du compte.');
                }
            });
        }
    });
});
