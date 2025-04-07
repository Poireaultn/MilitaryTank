<?php
include "Header.php";
require_once 'bdd.php';

$tabUrl = parse_url($_SERVER['REQUEST_URI']);
$listparam = explode("&",$tabUrl['query']);
$nb_param = count($listparam);

// on associe les valeurs 
for ($i = 0; $i < $nb_param; $i++) {
    $param = explode("=", $listparam[$i]);
    $_SESSION["categorie"] = $param[1];
}

// Conversion du format de l'URL vers le format de la base de données
$categorieDB = '';
switch($_SESSION["categorie"]) {
    case 'TanksLourd':
        $categorieDB = 'tanksLourd';
        break;
    case 'TanksMoyen':
        $categorieDB = 'tanksMoyen';
        break;
    case 'TanksLeger':
        $categorieDB = 'tanksLeger';
        break;
}

// Récupération des tanks depuis la base de données
$db = Database::getInstance();
$tanks = $db->getTanksByCategorie($categorieDB);

// Fonction pour obtenir la quantité dans le panier depuis la base de données
function getQuantitePanier($db, $id_produit, $id_client) {
    $query = "SELECT quantite FROM Panier WHERE id_produit = :id_produit AND id_client = :id_client";
    $stmt = $db->getConnection()->prepare($query);
    $stmt->execute([
        'id_produit' => $id_produit,
        'id_client' => $id_client
    ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? (int)$result['quantite'] : 0;
}

// Fonction pour calculer le stock disponible
function calculerStockDisponible($stockInitial, $quantitePanier) {
    return $stockInitial - $quantitePanier;
}
?>

<main>
  <div id="catalogue">
    <h1>Catalogue des <?php echo substr($_SESSION["categorie"], 0, 5) . " " . substr($_SESSION["categorie"], 5); ?></h1>
    <button id="toggleStock">Masquer Stock</button>
    <table>
      <thead>
        <tr>
          <th>Photo</th>
          <th>Désignation</th>
          <th>Prix</th>
          <th class="stock-col">Quantité en stock</th>
          <th>Quantité commandée</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      <?php
      if ($tanks) {
          foreach ($tanks as $tank) {
              $stockInitial = $tank['stock'];
              $id = $tank['id_produit'];
              $quantitePanier = isset($_SESSION["Connecté"]) ? getQuantitePanier($db, $id, $_SESSION["id_client"]) : 0;
              $stockDisponible = calculerStockDisponible($stockInitial, $quantitePanier);
              ?>
              <tr>
                <td>
                  <div class="img-container">
                    <img src="img/<?php echo $tank['image']; ?>" alt="<?php echo $tank['nom']; ?>">
                  </div>
                </td>
                <td><?php echo $tank['nom']; ?></td>
                <td><?php echo number_format($tank['prix'], 3, '.', ' '); ?> €</td>
                <td class="stock-col">
                  <span class="stock-number" data-stock-initial="<?php echo $stockInitial; ?>"><?php echo $stockDisponible; ?></span>
                  <?php if ($quantitePanier > 0) : ?>
                    <span class="panier-info">(<?php echo $quantitePanier; ?> dans votre panier)</span>
                  <?php endif; ?>
                </td>
                <td>
                  <button class="minus">-</button>
                  <span class="qty-commandee">0</span>
                  <button class="plus">+</button>
                </td>
                <td>
                  <button class="add-to-cart" data-product-id="<?php echo $id; ?>" <?php if ($stockDisponible <= 0) echo 'disabled'; ?>>
                    Ajouter au panier
                  </button>
                </td>
              </tr>
              <?php
          }
      }
      ?>
      </tbody>
    </table>
  </div>    
</main>

<?php
include "Footer.php";
?>