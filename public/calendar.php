<?php

require_once '../config/config.php';

ob_start();

?>

Pas encore fait
<?php
$content = ob_get_clean();
Template::render($content, "calendar");