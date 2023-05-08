<?php

require_once '../config/config.php';

class SeedRenderer
{

    public static function renderAll(array $seeds): void
    {
?>
        <div id="seeds_container">
            <?php
            foreach ($seeds as $seed) {
                self::renderSeed($seed);
            }
            ?>
        </div>
    <?php
    }

    public static function renderSeed(Seed $seed): void
    {
        // Récupérations des données de la graine et vérifications
        if ($seed === null) {
            return;
        }

        $planting_period_min = $seed->getPlantingPeriodMin() !== null ? $seed->getPlantingPeriodMin() : -1;
        $planting_period_max = $seed->getPlantingPeriodMax() !== null ? $seed->getPlantingPeriodMax() : -1;
        $harvest_period_min = $seed->getHarvestPeriodMin() !== null ? $seed->getHarvestPeriodMin() : -1;
        $harvest_period_max = $seed->getHarvestPeriodMax() !== null ? $seed->getHarvestPeriodMax() : -1;

        $advices = $seed->getAdvices() !== null ? $seed->getAdvices() : "Non renseigné";
        $image = $seed->getImage() !== null ? $seed->getImage() : null;
        $quantity = $seed->getQuantity() !== null ? $seed->getQuantity() : "Non renseigné";

        $planting_period = "Non renseigné";
        if ($planting_period_min !== "Non renseigné" && $planting_period_max !== "Non renseigné") {
            $planting_period = "Entre " . Calendar::getMonth($planting_period_min) . " et " . Calendar::getMonth($planting_period_max);
        }

        $harvest_period = "Non renseigné";
        if ($harvest_period_min !== "Non renseigné" && $harvest_period_max !== "Non renseigné") {
            $harvest_period = "Entre " . Calendar::getMonth($harvest_period_min) . " et " . Calendar::getMonth($harvest_period_max);
        }
    ?>
        <div class="seed">
            <h2 class="name"><?= $seed->getName() ?></h2>
            <p class="family light_text"><?= $seed->getFamily() ?></p>
            <p class="planting-period"><span class="bold">Période de plantation : </span> <?= $planting_period ?></p>
            <p class="harvest-period"><span class="bold">Période de récolte : </span> <?= $harvest_period ?></p>
            <?php if ($image !== null) : ?>
                <img class="image" src="<?= SEEDS_ASSETS_PATH . $image ?>" alt="<?= $seed->getName() ?>">
            <?php endif; ?>
            <p class="advices"><span class="bold">Conseils : </span><?= $advices ?></p>
            <p class="quantity"><span class="bold">Stock : </span><?= $quantity ?></p>
            <?php if (isset($_SESSION["logged"]) && $_SESSION["logged"]) { ?>
                <div class="actions">
                    <a class="admin_buttons" href="<?= PUBLIC_PATH ?>editSeed.php?id=<?= $seed->getId() ?>">Modifier</a>
                    <a class="admin_buttons" href="<?= HANDLERS_PATH ?>deleteseed.php?id=<?= $seed->getId() ?>">Supprimer</a>
                </div>
            <?php } ?>
        </div>
<?php
    }
}
