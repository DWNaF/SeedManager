<?php

require_once "../config/config.php";
require_once "../config/csrf.php";

ob_start();

if (!isset($_SESSION["logged"]) || $_SESSION["logged"] == false) {

    if (!isset($_SESSION['csrf_token'])) generateCsrfToken();

    Logger::generateLogger($_SESSION['csrf_token']);

    if (isset($_POST["login"]) && isset($_POST["password"])) {

        // Vérifier le jeton CSRF avant de valider les informations d'identification
        if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {
            $granted = Logger::log($_POST["login"], $_POST["password"]);
            if ($granted) {
                $_SESSION["logged"] = true;
                header("Location: " . PUBLIC_PATH . "list_seeds.php");
                exit();
            }
        } else {
            // Le jeton CSRF est invalide
            header("Location: " . PUBLIC_PATH . "login.php");
            exit();
        }
    }
} else { // Déja connecté
    header("Location: " . PUBLIC_PATH . "list_seeds.php");
    exit();
}

$content = ob_get_clean();
Template::render($content, "login");
