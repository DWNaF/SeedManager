<?php

require_once '../config/config.php';

if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    header("Location: " . PUBLIC_PATH . "list_seeds.php");
    exit();
}

$seed = SeedDB::getSeed($id);
if ($seed == null) {
    header("Location: " . PUBLIC_PATH . "list_seeds.php");
    exit();
}

ob_start();
SeedRenderer::renderUniqueSeed($seed);
?>

<?php

$content = ob_get_clean();
Template::render($content, "seed");

?>