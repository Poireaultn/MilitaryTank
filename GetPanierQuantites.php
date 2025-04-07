<?php
session_start();
require_once 'bdd.php';

header('Content-Type: application/json');

$quantites = array();

if (isset($_SESSION["Connecté"]) && isset($_SESSION["id_client"])) {
    $db = Database::getInstance();
    $query = "SELECT id_produit, quantite FROM Panier WHERE id_client = :id_client";
    $stmt = $db->getConnection()->prepare($query);
    $stmt->execute(['id_client' => $_SESSION["id_client"]]);
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $quantites[$row['id_produit']] = array(
            "quantite" => $row['quantite']
        );
    }
}

echo json_encode($quantites);
?> 