<?php
session_start();

function validerEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validerDate($date) {
    $dateObj = DateTime::createFromFormat('Y-m-d', $date);
    return $dateObj && $dateObj->format('Y-m-d') === $date;
}

$erreurs = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validation du prénom
    if (empty($_POST['prenom'])) {
        $erreurs['prenom'] = "Veuillez entrer votre prénom.";
    }

    // Validation du nom
    if (empty($_POST['nom'])) {
        $erreurs['nom'] = "Veuillez entrer votre nom.";
    }

    // Validation de l'email
    if (empty($_POST['email']) || !validerEmail($_POST['email'])) {
        $erreurs['email'] = "Veuillez entrer une adresse email valide.";
    }

    // Validation de la date de naissance
    if (empty($_POST['naissance']) || !validerDate($_POST['naissance'])) {
        $erreurs['naissance'] = "Veuillez entrer une date de naissance valide.";
    }

    // Validation du genre
    if (!isset($_POST['genre'])) {
        $erreurs['genre'] = "Veuillez sélectionner un genre.";
    }

    // Validation du sujet
    if (empty($_POST['sujet'])) {
        $erreurs['sujet'] = "Veuillez entrer un sujet.";
    }

    // Validation du message
    if (empty($_POST['message'])) {
        $erreurs['message'] = "Veuillez écrire un message.";
    }

    // Si aucune erreur, on traite le formulaire
    if (empty($erreurs)) {
        // Ici, vous pouvez ajouter le code pour traiter le formulaire (envoi d'email, sauvegarde en base de données, etc.)
        $_SESSION['message_succes'] = "Votre message a été envoyé avec succès !";
        header("Location: contact.php");
        exit();
    } else {
        $_SESSION['erreurs'] = $erreurs;
        $_SESSION['donnees_formulaire'] = $_POST;
        header("Location: contact.php");
        exit();
    }
}
?> 