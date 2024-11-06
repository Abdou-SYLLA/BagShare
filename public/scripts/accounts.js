$(document).ready(function() {
    // Fonction pour charger les comptes utilisateur
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

    // Ouvrir le modal d'édition pour un compte
    $(document).on('click', '.editAccountBtn', function() {
        const accountId = $(this).data('id');
        
        $.ajax({
            url: '/src/controllers/AccountController.php',
            type: 'POST',
            data: { action: 'getUser', userId: accountId },
            dataType: 'json',
            success: function(account) {
                if (account) {
                    $('#editNom').val(account.nom).prop('disabled', true);
                    $('#editPrenom').val(account.prenom).prop('disabled', true);
                    $('#editRole').val(account.role).prop('disabled', true);
                    $('#editUsername').val(account.username).prop('disabled', true);
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

    // Fermer le modal d'édition lorsqu'on clique en dehors
    $('#editUserModal').on('click', function(event) {
        if (event.target.id === 'editUserModal') {
            $('#editUserModal').fadeOut();
        }
    });

    // Activer/désactiver un champ de formulaire
    function enableField(fieldId) {
        const field = document.getElementById(fieldId);
        field.disabled = !field.disabled;
        field.focus();
        const button = field.nextElementSibling;
        button.innerText = field.disabled ? "Modifier" : "Annuler";
    }

    // Soumission du formulaire d'édition de l'utilisateur
    $('#editUserForm').on('submit', function(e) {
        e.preventDefault();
        const accountId = $(this).data('id');
        const data = $(this).serialize() + `&action=updateAccount&userId=${accountId}`;
        
        $.ajax({
            url: '/src/controllers/AccountController.php',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(response) {
                alert(response.message || 'Modification enregistrée avec succès.');
                $('#editUserModal').fadeOut();
                loadAccounts();
            },
            error: function(xhr, status, error) {
                console.error("Erreur lors de la mise à jour :", status, error);
                alert("Erreur : " + xhr.responseText);
            }
        });
    });

    // Activer le champ d'édition dans le formulaire
    $('#editUserForm .edit-field-btn').on('click', function() {
        const fieldId = $(this).prev('input, select').attr('id');
        enableField(fieldId);
    });

    // Suppression d'un compte utilisateur
    $(document).on('click', '.deleteAccountBtn', function() {
        const accountId = $(this).data('id');
        if (confirm("Voulez-vous vraiment supprimer ce compte ?")) {
            $.ajax({
                url: '/src/controllers/AccountController.php',
                type: 'POST',
                data: { action: 'delete', numero: accountId },
                dataType: 'json',
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
