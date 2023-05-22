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


    public static function renderSeed(?Seed $seed): void
    {
        if ($seed === null) return;
        $image = $seed->getImage() !== null && file_exists(SEEDS_ASSETS_PATH_FULL . $seed->getImage()) ? $seed->getImage() : "unavailable.png";
    ?>
        <div class="seed">
            <img class="seed_image" src="<?= SEEDS_ASSETS_PATH . $image ?>" alt="<?= $seed->getName() ?>">
            <a class="seed_name_container" href="<?= PUBLIC_PATH . "seed.php?id=" . $seed->getId() ?>"><?= $seed->getName() ?></a>
            <?php if (isset($_SESSION["logged"]) && $_SESSION["logged"]) { ?>
                <div id="admin_buttons_container">
                    <a id="edit_btn" class="admin_buttons" href="<?= PUBLIC_PATH ?>admin.php?id=<?= $seed->getId() ?>"></a>
                    <a class="admin_buttons delete_seed_btn" href="<?= HANDLERS_PATH ?>deleteseed.php?id=<?= $seed->getId() ?>"></a>
                </div>
            <?php } ?>

        </div>
    <?php
    }
    public static function renderUniqueSeed(Seed $seed): void
    {
        // Récupération des données de la graine et vérifications
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
        if ($planting_period_min !== -1 && $planting_period_max !== -1) {
            $planting_period = "Entre " . Calendar::getMonth($planting_period_min) . " et " . Calendar::getMonth($planting_period_max);
        }

        $harvest_period = "Non renseigné";
        if ($harvest_period_min !== -1 && $harvest_period_max !== -1) {
            $harvest_period = "Entre " . Calendar::getMonth($harvest_period_min) . " et " . Calendar::getMonth($harvest_period_max);
        }
    ?>
        <div class="seed">
            <a class="back" href="<?= PUBLIC_PATH ?>list_seeds.php">Retour</a>
            <h2 class="name"><?= $seed->getName() ?></h2>
            <p class="family light_text"><?= $seed->getFamily() ?></p>
            <p class="planting-period"><strong>Période de plantation : </strong><?= $planting_period ?></p>
            <p class="harvest-period"><strong>Période de récolte : </strong><?= $harvest_period ?></p>
            <?php if ($image !== null) : ?>
                <img class="image" src="<?= SEEDS_ASSETS_PATH . $image ?>" alt="<?= $seed->getName() ?>">
            <?php endif; ?>
            <p class="advices"><strong>Conseils : </strong><?= $advices ?></p>
            <p class="quantity"><strong>Stock : </strong><?= $quantity ?>g</p>
            <?php if (isset($_SESSION["logged"]) && $_SESSION["logged"]) { ?>
                <div class="actions">
                    <a class="admin_buttons" href="<?= PUBLIC_PATH ?>admin.php?id=<?= $seed->getId() ?>">Modifier</a>
                    <a class="delete_seed_btn admin_buttons" href="<?= HANDLERS_PATH ?>deleteseed.php?id=<?= $seed->getId() ?>">Supprimer</a>
                </div>
            <?php } ?>
        </div>
<?php
    }
}
