// Fonction pour basculer entre l'édition et la lecture seule pour chaque champ
function toggleEdit(fieldId) {
    const field = document.getElementById(fieldId);
    if (field.hasAttribute('readonly') || field.hasAttribute('disabled')) {
        field.removeAttribute('readonly');
        field.removeAttribute('disabled');
    } else {
        field.setAttribute(field.tagName === 'SELECT' ? 'disabled' : 'readonly', true);
    }
}

$(document).ready(function() {
    // Reste du code pour charger et gérer les comptes
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
                $('#editUserModal').fadeIn();
                $('#editUserForm').data('id', accountId);

                // Faire défiler la page vers le modal
                $('html, body').animate({
                    scrollTop: $('#editUserModal').offset().top
                }, 500);
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
            success: function() {
                alert('Compte mis à jour avec succès.');
                $('#editUserModal').fadeOut();
                loadAccounts();
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
                    loadAccounts();
                },
                error: function() {
                    alert('Erreur lors de la suppression du compte.');
                }
            });
        }
    });
});
