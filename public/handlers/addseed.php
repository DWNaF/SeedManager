<?php
require_once "../../config/config.php";

// On vérifie que l'utilisateur est connecté et qu'il a bien accès à cette page
if (session_status() != PHP_SESSION_ACTIVE) session_start();
if (!isset($_SESSION["logged"]) || $_SESSION["logged"] == false) {
    header("Location: " . REL_PATH . "error");
    exit();
}

// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom_fichier = Form::uploadImage($_FILES['image']);

    $seed = new Seed;
    $seed = $seed::new(
        $_POST["name"],
        $_POST["family"],
        $_POST["planting_period_min"],
        $_POST["planting_period_max"],
        $_POST["harvest_period_min"],
        $_POST["harvest_period_max"],
        $_POST["advices"],
        $nom_fichier,
        $_POST["quantity"]
    );

    // Ajoute la graine dans la base de données
    $seedDB = new SeedDB();
    $result = $seedDB->addSeed($seed);

    if ($result) {
        header("Location: " . PUBLIC_PATH . "list_seeds.php");
        exit();
    } else {
        echo "Erreur : Impossible d'ajouter la graine.";
    }
}
