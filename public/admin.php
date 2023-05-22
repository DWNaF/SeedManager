<?php

require_once '../config/config.php';

// On vérifie que l'utilisateur est connecté et qu'il a bien accès à cette page
if (!isset($_SESSION["logged"]) || $_SESSION["logged"] == false) {
    header("Location: " . PUBLIC_PATH . "list_seeds.php");
    exit();
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    $id = null;
}

$seed = SeedDB::getSeed($id);

ob_start();


Form::renderSeedForm($seed);
?>


<?php

$content = ob_get_clean();
Template::render($content, "admin");

?>