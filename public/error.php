<?php

require_once '../config/config.php';

ob_start();

?>

<main>
    <h1>Une erreur est survenue !</h1>
    <a href="<?= PUBLIC_PATH?>home.php">Retour à l'accueil</a>
</main>

<?php

$content = ob_get_clean();
Template::render($content, "error");

?>
