<?php
// Inclure le modèle User
require_once '../models/User.php';

// Définir le Content-Type pour JSON
header('Content-Type: application/json');

// Créer une instance du modèle User
$user = new User();

// Vérifier le type de requête
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si l'action est spécifiée
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'addUser':
                // Vérifier si les données nécessaires sont présentes dans la requête POST
                if (isset($_POST['nom'], $_POST['prenom'], $_POST['role'], $_POST['numero'])) {
                    // Récupérer les données POST
                    $nom = $_POST['nom'];
                    $prenom = $_POST['prenom'];
                    $role = $_POST['role'];
                    $numero = $_POST['numero'];

                    // Appeler la méthode pour ajouter un utilisateur
                    $result = $user->addUser($nom, $prenom, $role, $numero);

                    // Vérifier le résultat et renvoyer la réponse
                    if ($result) {
                        echo json_encode(['message' => 'Utilisateur ajouté avec succès']);
                    } else {
                        echo json_encode(['message' => 'Erreur lors de l\'ajout de l\'utilisateur']);
                    }
                } else {
                    // Si les données POST sont manquantes
                    echo json_encode(['message' => 'Données manquantes pour l\'ajout']);
                }
                break;

            case 'updateUser':
                // Vérifier si les données nécessaires sont présentes dans la requête POST
                if (isset($_POST['nom'], $_POST['prenom'], $_POST['role'], $_POST['numero'])) {
                    // Récupérer les données POST
                    $nom = $_POST['nom'];
                    $prenom = $_POST['prenom'];
                    $role = $_POST['role'];
                    $numero = $_POST['numero'];

                    // Appeler la méthode de mise à jour des informations
                    $result = $user->updateUser($nom, $prenom, $role, $numero);

                    // Vérifier le résultat et renvoyer la réponse
                    if (strpos($result, 'succès') !== false) {
                        echo json_encode(['message' => 'Utilisateur modifié avec succès']);
                    } else {
                        echo json_encode(['message' => $result]);
                    }
                } else {
                    // Si les données POST sont manquantes
                    echo json_encode(['message' => 'Données manquantes pour la modification']);
                }
                break;

            case 'deleteUser':
                // Vérifier si le numéro de l'utilisateur est présent
                if (isset($_POST['numero'])) {
                    $numero = $_POST['numero'];

                    // Appeler la méthode pour supprimer l'utilisateur
                    $result = $user->deleteUser($numero); // Méthode fictive à créer dans le modèle

                    // Vérifier le résultat et renvoyer la réponse
                    if ($result) {
                        echo json_encode(['message' => 'Utilisateur supprimé avec succès']);
                    } else {
                        echo json_encode(['message' => 'Erreur lors de la suppression de l\'utilisateur']);
                    }
                } else {
                    echo json_encode(['message' => 'Numéro de l\'utilisateur manquant pour la suppression']);
                }
                break;

            default:
                echo json_encode(['message' => 'Action non reconnue']);
                break;
        }
    } else {
        echo json_encode(['message' => 'Action non spécifiée']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' ) {
    if($_GET['action'] === "getAllUsers"){
            // Si la requête est un GET, retourner la liste des utilisateurs
        try {
            // Récupérer tous les utilisateurs
            $users = $user->getAllUsers();

            // Si des utilisateurs sont trouvés, renvoyer en JSON
            if (!empty($users)) {
                echo json_encode($users);
            } else {
                // S'il n'y a pas d'utilisateurs, renvoyer un tableau vide
                echo json_encode([]);
            }
        } catch (Exception $e) {
            // En cas d'erreur, renvoyer un message d'erreur en JSON
            echo json_encode(['error' => 'Erreur lors de la récupération des utilisateurs.']);
        }
    } else {
        // Si la méthode HTTP n'est ni GET ni POST, retourner une erreur
        echo json_encode(['message' => 'Méthode non supportée']);
    }
    }
   
?>
