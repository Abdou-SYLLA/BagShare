<?php
session_start();

// Vérification si le formulaire a été soumis via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $firstName = trim($_POST['first-name']);
    $lastName = trim($_POST['last-name']);
    $email = trim($_POST['email']);
    $question = trim($_POST['question']);
    
    // Validation des champs (simple exemple)
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

    // Création du contenu de l'email
    $subject = "Nouvelle question de " . $firstName . " " . $lastName;
    $message = "Vous avez reçu une nouvelle question via le formulaire de contact.\n\n";
    $message .= "Nom: " . $firstName . " " . $lastName . "\n";
    $message .= "Email: " . $email . "\n\n";
    $message .= "Question:\n" . $question . "\n";

    // Entêtes de l'email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8" . "\r\n";
    $headers .= "From: " . $email . "\r\n";  // L'adresse email de l'utilisateur
    $headers .= "Reply-To: " . $email . "\r\n";  // Répondre à l'email de l'utilisateur

    // Envoi de l'email
    $to = "asylla@alwaysdata.net"; // Remplacez par votre adresse email
    if (mail($to, $subject, $message, $headers)) {
        $_SESSION['success'] = "Votre message a été envoyé avec succès. Nous vous répondrons sous peu.";
    } else {
        $_SESSION['error'] = "Une erreur est survenue lors de l'envoi de votre message. Veuillez réessayer.";
    }

    // Redirection vers la page contact avec message de succès ou d'erreur
    header("Location: /src/views/contact.php");
    exit;
}
?>
