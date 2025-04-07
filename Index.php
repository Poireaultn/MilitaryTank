<?php
include "Header.php";
require_once 'bdd.php';

// Initialisation de la connexion à la base de données
$db = Database::getInstance();
?>  
<main>
  <h1>Bienvenue sur le site de Military Tank</h1>
  <p><b>Military Tank</b> est une entreprise spécialisée dans la <b>vente de tanks anciens démilitarisés</b>, destinés aux passionnés de véhicules militaires, aux collectionneurs ou aux projets de reconstitution historique.
    Chaque tank que nous proposons a été <b>soigneusement restauré, sécurisé</b> et <b>légalement désarmé</b>, dans le respect des normes en vigueur.<br>
    Que vous soyez un amateur éclairé ou un professionnel du cinéma ou de l'événementiel, <b>Military Tank</b> vous offre l'opportunité unique de posséder une véritable pièce d'histoire.</p>
</main>
<?php
include "Footer.php";
?>