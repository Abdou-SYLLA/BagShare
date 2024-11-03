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

    // Fermer la modale lorsque l'utilisateur clique à l'extérieur
    $('#editUserModal').on('click', function(event) {
        if (event.target.id === 'editUserModal') {
            $('#editUserModal').fadeOut();
        }
    });

    // Fonction pour activer/désactiver un champ pour l'édition
    function enableField(fieldId) {
        const field = document.getElementById(fieldId);
        field.disabled = !field.disabled; // Active ou désactive le champ
        field.focus(); // Met le focus sur le champ

        // Changer le texte du bouton pour indiquer l'état actuel
        const button = field.nextElementSibling;
        button.innerText = field.disabled ? "Modifier" : "Annuler";
    }

    // Gestion de la soumission du formulaire de modification
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

    // Activer la modification de chaque champ individuellement
    $('#editUserForm .edit-field-btn').on('click', function() {
        const fieldId = $(this).prev('input, select').attr('id');
        enableField(fieldId);
    });

    // Suppression d'un compte
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
