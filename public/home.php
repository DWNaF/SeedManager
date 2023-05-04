<?php

require_once '../config/config.php';

ob_start();

?>

<main>
    <h1 class="bounce_top">Bienvenue sur mon site de gestion de graines !</h1>
</main>

<?php

$content = ob_get_clean();
Template::render($content, "home");

?>