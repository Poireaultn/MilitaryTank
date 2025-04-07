<?php
include "Header.php";
require_once 'bdd.php';

if (!isset($_SESSION["Connecté"])) {
    header("location:Index.php");
    exit();
}

$db = Database::getInstance();

// Récupérer les articles du panier depuis la base de données
$query = "SELECT p.*, pa.quantite 
          FROM Panier pa 
          JOIN Produits p ON pa.id_produit = p.id_produit 
          WHERE pa.id_client = :id_client";
$stmt = $db->getConnection()->prepare($query);
$stmt->execute(['id_client' => $_SESSION["id_client"]]);
$panierItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main>
    <h1>Votre Panier</h1>
    <?php if (empty($panierItems)) { ?>
        <p>Votre panier est vide.</p>
    <?php } else { ?>
        <table>
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Produit</th>
                    <th>Prix unitaire</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($panierItems as $item) {
                    $sousTotal = $item['prix'] * $item['quantite'];
                    $total += $sousTotal;
                    ?>
                    <tr>
                        <td>
                            <div class="img-container">
                                <img src="img/<?php echo $item['image']; ?>" alt="<?php echo $item['nom']; ?>">
                            </div>
                        </td>
                        <td><?php echo $item['nom']; ?></td>
                        <td><?php echo number_format($item['prix'], 3, '.', ' '); ?> €</td>
                        <td><?php echo $item['quantite']; ?></td>
                        <td><?php echo number_format($sousTotal, 3, '.', ' '); ?> €</td>
                        <td>
                            <form action="SupprimerDuPanier.php" method="post">
                                <input type="hidden" name="productId" value="<?php echo $item['id_produit']; ?>">
                                <button type="submit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4"><strong>Total du panier :</strong></td>
                    <td colspan="2"><strong><?php echo number_format($total, 3, '.', ' '); ?> €</strong></td>
                </tr>
            </tfoot>
        </table>
    <?php } ?>
</main>

<?php
include "Footer.php";
?> 