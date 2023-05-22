<?php

require_once "../../config/config.php";

if (!isset($_POST["id"]) || $_POST["id"] == -1) {
    header("Location: " . PUBLIC_PATH . "list_seeds.php");
    exit();
}


$id = $_POST["id"];
$name = $_POST["name"];
$family = SeedDB::getFamilyId($_POST["family"]);
if ($family == null) {
    // Si la famille n'existe pas, on la crée
    $family = SeedDB::addFamily(ucfirst($_POST["family"]));
    $family = SeedDB::getFamilyId(ucfirst($_POST["family"]));
}
$planting_period_min = $_POST["planting_period_min"];
$planting_period_max = $_POST["planting_period_max"];
$harvest_period_min = $_POST["harvest_period_min"];
$harvest_period_max = $_POST["harvest_period_max"];
$advices = $_POST["advices"];
$image = $_FILES["image"] ?? null;
if ($image != null) $nom_fichier = Form::uploadImage($image);
else $nom_fichier = null;

$quantity = $_POST["quantity"];

if (SeedDB::updateSeed($id, $name, $family, $planting_period_min, $planting_period_max, $harvest_period_min, $harvest_period_max, $advices, $nom_fichier, $quantity)){
    header("Location: " . PUBLIC_PATH . "list_seeds.php");
    exit();
} else {
    header("Location: " . PUBLIC_PATH . "list_seeds.php?error=1");
    exit();
}
