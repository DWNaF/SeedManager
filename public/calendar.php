<?php

require_once '../config/config.php';

ob_start();

?>

<h1>Calendrier des plantations</h1>
<?php

// Création d'une instance de la classe Calendar
$calendar = new Calendar();
echo $calendar;

$content = ob_get_clean();
Template::render($content, "calendar");
