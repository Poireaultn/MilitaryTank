-- Création de la base de données
CREATE DATABASE IF NOT EXISTS military_tank;
USE military_tank;

-- Table des catégories
CREATE TABLE IF NOT EXISTS Categories (
    id_categorie INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL UNIQUE
);

-- Table des clients
CREATE TABLE IF NOT EXISTS Clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des produits
CREATE TABLE IF NOT EXISTS Produits (
    id_produit INT AUTO_INCREMENT PRIMARY KEY,
    tank_id VARCHAR(100) NOT NULL UNIQUE,
    nom VARCHAR(100) NOT NULL,
    id_categorie INT NOT NULL,
    prix DECIMAL(10,3) NOT NULL,
    stock INT NOT NULL,
    image VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_categorie) REFERENCES Categories(id_categorie)
);

-- Table du panier
CREATE TABLE IF NOT EXISTS Panier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_client INT NOT NULL,
    id_produit INT NOT NULL,
    quantite INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_client) REFERENCES Clients(id),
    FOREIGN KEY (id_produit) REFERENCES Produits(id_produit)
);

-- Insertion des catégories
INSERT INTO Categories (nom) VALUES
('tanksLeger'),
('tanksMoyen'),
('tanksLourd');

-- Insertion des clients de test
INSERT INTO Clients (login, mot_de_passe) VALUES
('PaulFruton', 'PaulFrutonmdp'),
('RomainDujol', 'RomainDujolmdp'),
('BorisLabrador', 'BorisLabradormdp');

-- Insertion des tanks
INSERT INTO Produits (tank_id, nom, id_categorie, prix, stock, image) VALUES
-- Tanks Moyens
('moyen_Leopard_1A5', 'Leopard 1A5', 2, 150.000, 20, 'Leopard_1A5.jpg'),
('moyen_AMX_30', 'AMX 30', 2, 130.000, 27, 'AMX_30.jpg'),
('moyen_Centurion_MK7/1', 'Centurion MK7/1', 2, 140.000, 8, 'Centurion_MK7|1.jpg'),
('moyen_Panther', 'Panther', 2, 175.000, 5, 'Panther.jpg'),
('moyen_T34-85', 'T34-85', 2, 175.000, 17, 'T34-85.jpg'),

-- Tanks Lourds
('lourd_Tigre_1', 'Tiger 1', 3, 250.000, 3, 'Tiger_1.jpg'),
('lourd_IS_3', 'IS 3', 3, 200.000, 20, 'IS_3.jpg'),
('lourd_AMX_50', 'AMX 50', 3, 190.000, 12, 'AMX_50.jpg'),
('lourd_M103', 'M103', 3, 210.000, 9, 'M103.jpg'),

-- Tanks Légers
('leger_AMX_13_105', 'AMX 13 105', 1, 150.000, 21, 'AMX_13_105.jpg'),
('leger_M551_Sheridan', 'M551 Sheridan', 1, 180.000, 12, 'M551_Sheridan.jpg'),
('leger_PT-76', 'PT-76', 1, 125.000, 14, 'PT-76.jpg'),
('leger_M3_Stuart', 'M3 Stuart', 1, 110.000, 19, 'M3_Stuart.jpg'); 