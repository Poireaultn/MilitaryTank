<?php
session_start();
require_once 'bdd.php';

if (!isset($_SESSION["Connecté"])) {
    header("location:Index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["productId"])) {
    $productId = $_POST["productId"];
    $id_client = $_SESSION["id_client"];
    
    $db = Database::getInstance();
    
    try {
        // Supprimer l'article du panier
        $query = "DELETE FROM Panier WHERE id_client = :id_client AND id_produit = :id_produit";
        $stmt = $db->getConnection()->prepare($query);
        $stmt->execute([
            'id_client' => $id_client,
            'id_produit' => $productId
        ]);
        
        header("location:Panier.php");
        exit();
    } catch (Exception $e) {
        error_log("Erreur lors de la suppression du panier : " . $e->getMessage());
        header("location:Panier.php?error=1");
        exit();
    }
} else {
    header("location:Panier.php");
    exit();
}
?> 