<?php

session_start();
require_once 'bdd.php';

header('Content-Type: application/json');

$login = array();
$password = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $password = $_POST["mdp"];

    error_log("Tentative de connexion - Login: " . $login . ", Password: " . $password);

    $db = Database::getInstance();
    $user = $db->verifierIdentifiants($login, $password);

    if ($user) {
        $_SESSION["Connecté"] = true;
        $_SESSION["login"] = $login;
        $_SESSION["id_client"] = $user['id'];
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Identifiants incorrects"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Méthode non autorisée"]);
}
?>