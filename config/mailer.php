<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';  // Si vous avez installé via Composer

// Fonction pour envoyer l'email
function sendContactEmail($firstName, $lastName, $email, $question) {
    $mail = new PHPMailer(true);
    
    try {
        // Configuration du serveur SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp-asylla.alwaysdata.net';  // Serveur SMTP d'Alwaysdata
        $mail->SMTPAuth = true;
        $mail->Username = 'asylla@alwaysdata.net';  // Votre email (toujours complet)
        $mail->Password = 'Sylla@2024';  // Le mot de passe de votre email (assurez-vous qu'il soit sécurisé)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Sécurisation du protocole
        $mail->Port = 587;  // Port SMTP par défaut

        // Destinataire
        $mail->setFrom('lahat044@gmail.com', 'Abdou Sylla');
        $mail->addAddress('lahat044@gmail.com', 'Abdou Sylla');  // L'email auquel envoyer
        $mail->addReplyTo($email, $firstName . ' ' . $lastName);  // Répondre à l'email de l'utilisateur

        // Contenu du message
        $mail->isHTML(false);  // Choisir si l'email est en texte brut (false) ou HTML (true)
        $mail->Subject = 'Nouvelle question de ' . $firstName . ' ' . $lastName;
        $mail->Body    = "Vous avez reçu une nouvelle question via le formulaire de contact.\n\n";
        $mail->Body   .= "Nom: " . $firstName . " " . $lastName . "\n";
        $mail->Body   .= "Email: " . $email . "\n\n";
        $mail->Body   .= "Question:\n" . $question . "\n";

        // Débogage SMTP
        $mail->SMTPDebug = 2;  // Active le débogage pour le serveur SMTP

        // Envoi de l'email
        $mail->send();
        return true;  // Retourne true si l'email a été envoyé avec succès
    } catch (Exception $e) {
        // Gestion de l'erreur
        error_log("Erreur lors de l'envoi de l'email: " . $e->getMessage());  // Enregistre l'erreur dans le log
        return false;  // Retourne false si une erreur s'est produite
    }
}

// Traitement du formulaire de contact
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = trim($_POST['first-name']);
    $lastName = trim($_POST['last-name']);
    $email = trim($_POST['email']);
    $question = trim($_POST['question']);

    // Validation des champs
    if (empty($firstName) || empty($lastName) || empty($email) || empty($question)) {
        $_SESSION['error'] = "Tous les champs sont requis.";
        header("Location: /src/views/contact.php"); // Redirection vers la page contact avec message d'erreur
        exit;
    }

    // Validation de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "L'adresse email est invalide.";
        header("Location: /src/views/contact.php"); // Redirection vers la page contact avec message d'erreur
        exit;
    }

    // Envoi de l'email via PHPMailer
    if (sendContactEmail($firstName, $lastName, $email, $question)) {
        $_SESSION['success'] = "Votre message a été envoyé avec succès. Nous vous répondrons sous peu.";
    } else {
        $_SESSION['error'] = "Une erreur est survenue lors de l'envoi de votre message. Veuillez réessayer.";
    }

    // Redirection vers la page de contact
    header("Location: /contact");
    exit;
}
?>
