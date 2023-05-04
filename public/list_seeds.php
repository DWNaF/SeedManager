<?php

require_once '../config/config.php';

ob_start();
?>
<section id="main_content">

    <?php
    $SeedsDB = new SeedDB();
    $seeds = $SeedsDB->getAllSeeds();
    $families = $SeedsDB->getAllFamilies();

    $selectedFamily = $_GET['family'] ?? null;
    $searchQuery = $_GET['search'] ?? null;

    /**
     * TODO : Submit le forme lorsqu'on change de famille dans le form
     */

    SeedRenderer::renderFilterForm($families, $searchQuery);
    SeedRenderer::renderAll($seeds, $selectedFamily, $searchQuery);

    ?>
</section>
<?php
$content = ob_get_clean();
Template::render($content, "list_seeds");
?>