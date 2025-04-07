<?php
session_start();
require_once 'bdd.php';

// Initialisation de la connexion à la base de données
$db = Database::getInstance();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Military Tank - Tanks Moyen</title>
  <link rel="stylesheet" href="css/css.css">
  <link rel="shortcut icon" href="img/logo.jpg"/>
</head>
<body>
  <header>
    <div class="banner">
      <img src="img/logo.jpg" alt="Logo Military Tank">
      <?php
      if(isset($_SESSION["login"])){
        ?>
        <h2>Bienvenue <?php echo $_SESSION["login"]; ?></h2>
        <?php
      }
      ?>      
      <div class="connexion">
        <?php
        // Affiche le form de connection si il n'est pas connecté ou affiche le form de deconnexion sinon
        if(!isset($_SESSION["Connecté"])){
          ?>          
          <form action="VerifierConnection.php" method="post">
            <input type="text" id="login" name="login" placeholder="Identifiant">
            <input type="password" id="mdp" name="mdp" placeholder="Mot de passe">
            <button type="submit">Connexion</button>
          </form>
          <?php if (isset($_SESSION['erreur_connexion'])): ?>
            <div class="erreur-message">
              <?php 
              echo $_SESSION['erreur_connexion'];
              unset($_SESSION['erreur_connexion']);
              ?>
            </div>
          <?php endif; ?>
          <?php
        } else {
          ?>
          <form action="Deconnexion.php" method="get">
            <button type="submit">Déconnexion</button>
          </form>
          <?php
        }
        ?>         
      </div>
    </div>
    <nav>
      <ul>
        <li><a href="Index.php">Accueil</a></li>
        <li><a href="Produits.php?cat=TanksMoyen">Tanks Moyen</a></li>
        <li><a href="Produits.php?cat=TanksLourd">Tanks Lourd</a></li>
        <li><a href="Produits.php?cat=TanksLeger">Tanks Leger</a></li>
        <li><a href="contact.php">Contact</a></li>
        <?php if(isset($_SESSION["Connecté"])) { ?>
          <li><a href="Panier.php">Panier</a></li>
        <?php } ?>
      </ul>
    </nav>
  </header>