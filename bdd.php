<?php
require_once 'bddData.php';

class Database {
    private static $instance = null;
    private $conn;

    private function __construct() {
        try {
            $this->conn = new PDO("mysql:host=localhost;dbname=military_tank", "root", "cytech0001");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }

    // Fonction pour vérifier les identifiants
    public function verifierIdentifiants($login, $password) {
        try {
            $query = "SELECT * FROM Clients WHERE login = :login AND mot_de_passe = :password";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([
                'login' => $login,
                'password' => $password
            ]);
            
            // Pour le débogage
            if ($stmt->rowCount() === 0) {
                error_log("Aucun utilisateur trouvé pour login: $login");
                // Vérifions ce qui existe dans la base de données
                $query2 = "SELECT * FROM Clients WHERE login = :login";
                $stmt2 = $this->conn->prepare($query2);
                $stmt2->execute(['login' => $login]);
                $user = $stmt2->fetch(PDO::FETCH_ASSOC);
                if ($user) {
                    error_log("Utilisateur trouvé mais mot de passe incorrect. Mot de passe en base: " . $user['mot_de_passe'] . " vs fourni: " . $password);
                }
            }
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Erreur de vérification des identifiants : " . $e->getMessage());
            return null;
        }
    }

    // Fonction pour récupérer tous les tanks d'une catégorie
    public function getTanksByCategorie($categorie) {
        try {
            $query = "SELECT p.* 
                     FROM Produits p 
                     JOIN Categories c ON p.id_categorie = c.id_categorie 
                     WHERE c.nom = :categorie";
            $stmt = $this->conn->prepare($query);
            $stmt->execute(['categorie' => $categorie]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Erreur de récupération des tanks : " . $e->getMessage());
            return null;
        }
    }

    // Fonction pour récupérer le stock d'un tank
    public function getStockTank($id_produit) {
        try {
            $query = "SELECT stock FROM Produits WHERE id_produit = :id_produit";
            $stmt = $this->conn->prepare($query);
            $stmt->execute(['id_produit' => $id_produit]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['stock'] : null;
        } catch(PDOException $e) {
            error_log("Erreur de récupération du stock : " . $e->getMessage());
            return null;
        }
    }

    // Fonction pour mettre à jour le stock d'un tank
    public function updateStockTank($id_produit, $nouveau_stock) {
        try {
            $query = "UPDATE Produits SET stock = :stock WHERE id_produit = :id_produit";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([
                'stock' => $nouveau_stock,
                'id_produit' => $id_produit
            ]);
        } catch(PDOException $e) {
            error_log("Erreur de mise à jour du stock : " . $e->getMessage());
            return false;
        }
    }

    // Fonction pour récupérer les informations d'un tank
    public function getTankInfo($id_produit) {
        try {
            $query = "SELECT p.*, c.nom as categorie_nom 
                     FROM Produits p 
                     JOIN Categories c ON p.id_categorie = c.id_categorie 
                     WHERE p.id_produit = :id_produit";
            $stmt = $this->conn->prepare($query);
            $stmt->execute(['id_produit' => $id_produit]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Erreur de récupération des informations du tank : " . $e->getMessage());
            return null;
        }
    }
}
?> 