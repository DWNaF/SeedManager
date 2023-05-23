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

    if ($seeds != null && !empty($seeds)) {
        SeedRenderer::renderAll($seeds);
    } else {
    ?>
        <div class="warning" role="alert">
            <h3>Aucune graine ne correspond à votre recherche.</h3>
            <button type="reset" onclick="resetFilters()">Réinitialiser les filtres</button>
            <script>
                function resetFilters() {
                    window.location.href = window.location.pathname;
                }
            </script>
        </div>
    <?php
    }
    ?>
</section>
<?php
$content = ob_get_clean();
Template::render($content, "list_seeds");
?>