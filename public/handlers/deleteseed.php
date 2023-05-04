<?php

require_once "../../config/config.php";

// On vérifie que l'utilisateur est connecté et qu'il a bien accès à cette page
if (session_status() != PHP_SESSION_ACTIVE) session_start();

if (!isset($_SESSION["logged"]) || $_SESSION["logged"] == false) {
    header("Location: " . PUBLIC_PATH . "error");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {

    $seedDB = new SeedDB();
    $result = $seedDB->deleteSeed($_GET["id"]);

    if ($result) {
        header("Location: " . PUBLIC_PATH . "list_seeds.php");
        exit();
    } else {
        header("Location: " . PUBLIC_PATH . "error.php");
    }
}
