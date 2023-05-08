<?php

require_once '../config/config.php';

ob_start();
Form::init();
$seedDB = new SeedDB();
?>
<section id="main_content">

    <?php
    if (isset($_GET["filters"])) {
        $filters = $_GET["filters"];
    } else {
        $filters = null;
    }

    Form::renderFilterForm($filters);


    if (isset($filters) && $filters != null) {
        $seeds = $seedDB->getFilteredSeeds($filters);
    } else {
        $seeds = $seedDB->getAllSeeds();
    }

    SeedRenderer::renderAll($seeds);
    ?>
</section>
<?php
$content = ob_get_clean();
Template::render($content, "list_seeds");
?>