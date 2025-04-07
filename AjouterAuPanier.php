<?php
session_start();
require_once 'bdd.php';

if (!isset($_SESSION["Connecté"])) {
    echo json_encode(["success" => false, "message" => "Veuillez vous connecter"]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données
    $productId = $_POST['productId'];
    $quantite = intval($_POST['quantite']);
    $id_client = $_SESSION["id_client"];

    $db = Database::getInstance();
    
    // Vérifier si le produit existe déjà dans le panier
    $query = "SELECT quantite FROM Panier WHERE id_client = :id_client AND id_produit = :id_produit";
    $stmt = $db->getConnection()->prepare($query);
    $stmt->execute([
        'id_client' => $id_client,
        'id_produit' => $productId
    ]);
    $existingItem = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier le stock disponible
    $query = "SELECT stock FROM Produits WHERE id_produit = :id_produit";
    $stmt = $db->getConnection()->prepare($query);
    $stmt->execute(['id_produit' => $productId]);
    $produit = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$produit) {
        echo json_encode([
            "success" => false,
            "message" => "Produit non trouvé."
        ]);
        exit();
    }

    $stockInitial = $produit['stock'];
    $qtyInCart = $existingItem ? $existingItem['quantite'] : 0;
    $stockDisponible = $stockInitial - $qtyInCart;

    if ($quantite > $stockDisponible) {
        echo json_encode([
            "success" => false,
            "message" => "La quantité demandée dépasse le stock disponible."
        ]);
        exit();
    }

    try {
        $db->getConnection()->beginTransaction();

        if ($existingItem) {
            // Mettre à jour la quantité existante
            $query = "UPDATE Panier SET quantite = quantite + :quantite 
                     WHERE id_client = :id_client AND id_produit = :id_produit";
            $stmt = $db->getConnection()->prepare($query);
            $success = $stmt->execute([
                'quantite' => $quantite,
                'id_client' => $id_client,
                'id_produit' => $productId
            ]);
        } else {
            // Insérer un nouveau produit dans le panier
            $query = "INSERT INTO Panier (id_client, id_produit, quantite) 
                     VALUES (:id_client, :id_produit, :quantite)";
            $stmt = $db->getConnection()->prepare($query);
            $success = $stmt->execute([
                'id_client' => $id_client,
                'id_produit' => $productId,
                'quantite' => $quantite
            ]);
        }

        if ($success) {
            $db->getConnection()->commit();
            echo json_encode([
                "success" => true,
                "message" => "Produit ajouté au panier"
            ]);
        } else {
            $db->getConnection()->rollBack();
            echo json_encode([
                "success" => false,
                "message" => "Erreur lors de l'ajout au panier"
            ]);
        }
    } catch (Exception $e) {
        $db->getConnection()->rollBack();
        echo json_encode([
            "success" => false,
            "message" => "Erreur lors de l'ajout au panier: " . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        "success" => false, 
        "message" => "Méthode de requête non autorisée."
    ]);
}
?> 