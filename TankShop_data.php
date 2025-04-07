<?php
session_start();

// Fonction pour lire un fichier XML
function lireXML($fichier) {
    if (file_exists($fichier)) {
        return simplexml_load_file($fichier);
    }
    return false;
}

// Initialisation du fichier SQL
$sqlFile = "TankShop_data.sql";
file_put_contents($sqlFile, "-- Script d'insertion des données pour TankShop\n\n");
file_put_contents($sqlFile, "USE TankShop;\n\n", FILE_APPEND);

// Lecture des fichiers XML
$tanksXML = lireXML('xml/Tanks.xml');
$usersXML = lireXML('xml/Utilisateurs.xml');

if ($tanksXML && $usersXML) {
    // Insertion des catégories
    $categories = array('Tanks Légers', 'Tanks Moyens', 'Tanks Lourds');
    foreach ($categories as $cat) {
        $sql = "INSERT INTO Categories (nom) VALUES ('$cat');\n";
        file_put_contents($sqlFile, $sql, FILE_APPEND);
    }
    file_put_contents($sqlFile, "\n", FILE_APPEND);

    // Insertion des tanks
    foreach ($tanksXML->tanksLeger->tank as $tank) {
        $sql = "INSERT INTO Produits (id_produit, id_categorie, nom, prix, stock, image) VALUES ('" .
               $tank['id'] . "', 1, '" . $tank->nom . "', " . str_replace('.', '', $tank->prix) . 
               ", " . $tank->stock . ", '" . $tank->image . "');\n";
        file_put_contents($sqlFile, $sql, FILE_APPEND);
    }

    foreach ($tanksXML->tanksMoyen->tank as $tank) {
        $sql = "INSERT INTO Produits (id_produit, id_categorie, nom, prix, stock, image) VALUES ('" .
               $tank['id'] . "', 2, '" . $tank->nom . "', " . str_replace('.', '', $tank->prix) . 
               ", " . $tank->stock . ", '" . $tank->image . "');\n";
        file_put_contents($sqlFile, $sql, FILE_APPEND);
    }

    foreach ($tanksXML->tanksLourd->tank as $tank) {
        $sql = "INSERT INTO Produits (id_produit, id_categorie, nom, prix, stock, image) VALUES ('" .
               $tank['id'] . "', 3, '" . $tank->nom . "', " . str_replace('.', '', $tank->prix) . 
               ", " . $tank->stock . ", '" . $tank->image . "');\n";
        file_put_contents($sqlFile, $sql, FILE_APPEND);
    }
    file_put_contents($sqlFile, "\n", FILE_APPEND);

    // Insertion des utilisateurs
    foreach ($usersXML->Utilisateur as $user) {
        $sql = "INSERT INTO Clients (login, mot_de_passe) VALUES ('" . 
               $user->login . "', '" . $user->mdp . "');\n";
        file_put_contents($sqlFile, $sql, FILE_APPEND);
    }

    echo "Le fichier $sqlFile a été créé avec succès.";
} else {
    echo "Erreur lors de la lecture des fichiers XML.";
}
?> 