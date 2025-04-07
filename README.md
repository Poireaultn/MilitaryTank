# Site de Vente de Tanks Militaires

Ce projet est un site web de vente de tanks militaires développé en PHP. Il permet aux utilisateurs de parcourir un catalogue de tanks, de les ajouter à leur panier et de gérer leurs commandes.

## Prérequis

- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur
- Serveur web (Apache recommandé)
- PDO PHP Extension
- Un navigateur web moderne

## Installation

1. **Cloner le projet**
   ```bash
   git clone [URL_DU_REPO]
   cd [NOM_DU_DOSSIER]
   ```

2. **Configuration de la base de données**
   - Ouvrir le fichier `bdd.php`
   - Modifier les informations de connexion si nécessaire :
     ```php
     $host = "localhost";
     $user = "root";
     $password = "cytech0001";
     $dbname = "military_tank";
     ```

3. **Initialisation de la base de données**
   - Accéder au dossier du projet via le terminal
   - Exécuter le script d'initialisation :
     ```bash
     php init_database.php
     ```
   Ce script va :
   - Créer la base de données `military_tank`
   - Créer les tables nécessaires
   - Insérer les données initiales (catégories, tanks, utilisateurs de test)

4. **Configuration du serveur web**
   - Placer le projet dans le répertoire web de votre serveur
   - S'assurer que le serveur web a les permissions nécessaires sur les fichiers
   - Configurer le virtual host si nécessaire

## Structure de la base de données

La base de données contient les tables suivantes :
- `Categories` : Catégories de tanks (léger, moyen, lourd)
- `Clients` : Informations des utilisateurs
- `Produits` : Catalogue des tanks disponibles
- `Panier` : Gestion du panier des utilisateurs

## Comptes de test

Trois comptes utilisateurs sont créés par défaut :
- Login: PaulFruton / Mot de passe: PaulFrutonmdp
- Login: RomainDujol / Mot de passe: RomainDujolmdp
- Login: BorisLabrador / Mot de passe: BorisLabradormdp

## Fonctionnalités

- Catalogue de tanks avec filtrage par catégorie
- Système de panier
- Gestion des stocks en temps réel
- Zoom sur les images au survol
- Masquage/affichage des colonnes de stock
- Interface responsive

## Utilisation

1. Accéder au site via votre navigateur
2. Se connecter avec l'un des comptes de test
3. Parcourir le catalogue de tanks
4. Utiliser les boutons + et - pour ajuster les quantités
5. Ajouter des tanks au panier
6. Consulter le panier pour voir les articles sélectionnés

## Problèmes connus

Si vous rencontrez des erreurs lors de l'initialisation de la base de données :
1. Vérifier que MySQL est bien démarré
2. Vérifier les permissions de l'utilisateur MySQL
3. S'assurer que le port MySQL par défaut (3306) est utilisé

## Support

Pour toute question ou problème, vous pouvez :
1. Ouvrir une issue sur le repository
2. Contacter l'équipe de développement

## Licence

Ce projet est sous licence MIT. Voir le fichier LICENSE pour plus de détails. 