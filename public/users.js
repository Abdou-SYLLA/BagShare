// Fonction pour récupérer les utilisateurs avec AJAX
function loadUsers() {
    $.ajax({
        url: '/src/controllers/UserController.php', // Action pour charger les utilisateurs
        method: 'GET',
        dataType: 'json',
        data: { action:  "getAllUsers" },
        success: function(response) {
            $('#userTable tbody').empty();
            response.forEach(function(user) {
                $('#userTable tbody').append(`
                    <tr>
                        <td>${user.nom}</td>
                        <td>${user.prenom}</td>
                        <td>${user.role}</td>
                        <td>${user.numero}</td>
                        <td>
                            <button class="editBtn" data-numero="${user.numero}">Modifier</button>
                            <button class="deleteBtn" data-numero="${user.numero}">Supprimer</button>
                        </td>
                    </tr>
                `);
            });
        },
        error: function() {
            alert('Erreur lors de la récupération des utilisateurs.');
        }
    });
}

$(document).ready(function() {
    loadUsers();

    // Soumission du formulaire d'ajout d'utilisateur
    $('#addUserForm').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: '/src/controllers/UserController.php?action=addUser', // Action pour ajouter un utilisateur
            method: 'POST',
            data: $(this).serialize(),
            success: function() {
                $('#addUserForm')[0].reset();
                loadUsers();
            },
            error: function() {
                alert('Erreur lors de l\'ajout de l\'utilisateur.');
            }
        });
    });

    // Supprimer un utilisateur
    $(document).on('click', '.deleteBtn', function() {
        const userNumero = $(this).data('numero');
        if (confirm("Voulez-vous vraiment supprimer cet utilisateur ?")) {
            $.ajax({
                url: '/src/controllers/UserController.php?action=deleteUser', // Action pour supprimer un utilisateur
                method: 'POST',
                data: { numero: userNumero },
                success: function() {
                    loadUsers();
                },
                error: function() {
                    alert('Erreur lors de la suppression de l\'utilisateur.');
                }
            });
        }
    });

    // Ouvrir le modal pour modifier un utilisateur
    $(document).on('click', '.editBtn', function() {
        const userNumero = $(this).data('numero');
        $.ajax({
            url: '/src/controllers/UserController.php?action=getUser', // Action pour obtenir les données d'un utilisateur
            method: 'GET',
            data: { numero: userNumero },
            dataType: 'json',
            success: function(user) {
                $('#editNom').val(user.nom);
                $('#editPrenom').val(user.prenom);
                $('#editRole').val(user.role);
                $('#editNumero').val(user.numero); // Le numéro ne change pas, mais il est affiché pour info
                $('#editUserModal').show(); // Afficher le modal de modification
            },
            error: function() {
                alert('Erreur lors de la récupération des données utilisateur.');
            }
        });
    });

    // Modifier un utilisateur via le formulaire du modal
    $('#editUserForm').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: '/src/controllers/UserController.php?action=editUser', // Action pour modifier un utilisateur
            method: 'POST',
            data: $(this).serialize(),
            success: function() {
                $('#editUserModal').hide(); // Cacher le modal après modification
                loadUsers();
            },
            error: function() {
                alert('Erreur lors de la modification de l\'utilisateur.');
            }
        });
    });
});
