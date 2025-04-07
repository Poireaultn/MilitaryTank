<?php
require_once 'bdd.php';

try {
    // Connexion à MySQL sans sélectionner de base de données
    $pdo = new PDO("mysql:host=localhost", "root", "cytech0001");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Activer l'exécution de requêtes multiples
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0);

    // Supprimer la base de données si elle existe
    $pdo->exec("DROP DATABASE IF EXISTS military_tank");
    
    // Créer la base de données
    $pdo->exec("CREATE DATABASE military_tank");
    $pdo->exec("USE military_tank");

    // Lecture du fichier SQL
    $sql = file_get_contents('create_database.sql');

    // Exécution des requêtes SQL
    $pdo->exec($sql);

    echo "Base de données initialisée avec succès !\n";
    echo "Utilisateurs créés :\n";
    echo "- PaulFruton (mot de passe: PaulFrutonmdp)\n";
    echo "- RomainDujol (mot de passe: RomainDujolmdp)\n";
    echo "- BorisLabrador (mot de passe: BorisLabradormdp)\n";
    
    echo "\nCatégories créées :\n";
    echo "- tanksLeger\n";
    echo "- tanksMoyen\n";
    echo "- tanksLourd\n";
    
    echo "\nTanks ajoutés dans la base de données :\n";
    echo "- Tanks Moyens : Leopard 1A5, AMX 30, Centurion MK7/1, Panther, T34-85\n";
    echo "- Tanks Lourds : Tiger 1, IS 3, AMX 50, M103\n";
    echo "- Tanks Légers : AMX 13 105, M551 Sheridan, PT-76, M3 Stuart\n";

} catch(PDOException $e) {
    echo "Erreur lors de l'initialisation de la base de données : " . $e->getMessage() . "\n";
    // Afficher plus de détails sur l'erreur en développement
    if (isset($pdo)) {
        print_r($pdo->errorInfo());
    }
}
?> 