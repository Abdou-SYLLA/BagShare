$(document).ready(function() {
    // Fonction pour charger la liste des comptes
    function loadAccounts() {
        $.ajax({
            url: '/src/controllers/AccountController.php',
            type: 'POST',
            dataType: 'json',
            data: { action: 'getUserAccounts' },
            success: function(data) {
                $('#userTable tbody').empty();
                if (data && data.length > 0) {
                    data.forEach(account => {
                        $('#userTable tbody').append(`
                            <tr>
                                <td>${account.nom}</td>
                                <td>${account.prenom}</td>
                                <td>${account.role}</td>
                                <td>${account.username}</td>
                                <td>${account.numero}</td>
                                <td>
                                    <button class="editAccountBtn" data-id="${account.numero}">Modifier</button>
                                    <button class="deleteAccountBtn" data-id="${account.numero}">Supprimer</button>
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
                if (account) {
                    $('#editNom').val(account.nom);
                    $('#editPrenom').val(account.prenom);
                    $('#editRole').val(account.role);
                    $('#editUsername').val(account.username);

                    $('#editUserModal').fadeIn();
                    $('#editUserForm').data('id', accountId);
                } else {
                    alert("Aucun utilisateur trouvé.");
                }
            },
            error: function(xhr, status, error) {
                console.error("Erreur lors de la récupération des informations du compte :", xhr, status, error);
                alert('Erreur lors de la récupération des informations du compte.');
            }
        });
    });

    // Soumettre les modifications du compte
    $('#editUserForm').on('submit', function(event) {
        event.preventDefault();

        const formData = {
            action: 'updateAccount',
            userId: $(this).data('id'),
            nom: $('#editNom').val(),
            prenom: $('#editPrenom').val(),
            role: $('#editRole').val(),
            username: $('#editUsername').val(),
            password: $('#editPassword').val()
        };

        $.ajax({
            url: '/src/controllers/AccountController.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                alert(response.message || 'Compte mis à jour avec succès.');
                $('#editUserModal').fadeOut();
                loadAccounts();
            },
            error: function() {
                alert('Erreur lors de la mise à jour du compte.');
            }
        });
    });

    // Fermer la modale lorsque l'utilisateur clique à l'extérieur
    $('#editUserModal').on('click', function(event) {
        if (event.target.id === 'editUserModal') {
            $('#editUserModal').fadeOut();
        }
    });

    // Suppression d'un compte
    $(document).on('click', '.deleteAccountBtn', function() {
        const accountId = $(this).data('id');
        if (confirm("Voulez-vous vraiment supprimer ce compte ?")) {
            $.ajax({
                url: '/src/controllers/AccountController.php',
                type: 'POST',
                data: { action: 'delete', numero: accountId },
                success: function(response) {
                    alert(response.message || 'Compte supprimé avec succès.');
                    loadAccounts();
                },
                error: function() {
                    alert('Erreur lors de la suppression du compte.');
                }
            });
        }
    });
});
