<?php

require_once '../config/config.php';

ob_start();
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
        $seeds = SeedDB::getFilteredSeeds($filters);
    } else {
        $seeds = SeedDB::getAllSeeds();
    }

    SeedRenderer::renderAll($seeds);
    ?>
</section>
<?php
$content = ob_get_clean();
Template::render($content, "list_seeds");
?>