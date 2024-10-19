<?php
session_start();

// Définir la durée d'expiration de la session à 5 minutes (300 secondes)
ini_set('session.gc_maxlifetime', 300); // Délai d'expiration dans php.ini (durée maximale de la session)

// Contrôle personnalisé de l'inactivité de session (5 minutes)
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 300)) {
    // Si plus de 300 secondes se sont écoulées depuis la dernière activité, détruire la session
    session_unset();    // Supprimer toutes les variables de session
    session_destroy();   // Détruire la session
    header("Location: /bagshare/public/html/connexion.html?error=" . urlencode("Session expirée. Veuillez vous reconnecter."));
    exit();
}

// Mettre à jour l'heure de la dernière activité
$_SESSION['LAST_ACTIVITY'] = time();
?>
