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
        if ($seed == null) return;

        $planting_period = $seed->getPlantingPeriod() != null ? $seed->getPlantingPeriod() : "Non renseigné";
        $harvest_period = $seed->getHarvestPeriod() != null ? $seed->getHarvestPeriod() : "Non renseigné";
        $advices = $seed->getAdvices() != null ? $seed->getAdvices() : "Non renseigné";
        $image = $seed->getImage() != null ? $seed->getImage() : null;
        $quantity = $seed->getQuantity() != null ? $seed->getQuantity() : "Non renseigné";
    ?>
        <div class="seed">
            <h2 class="name"><?= $seed->getName() ?></h2>
            <p class="family light_text"><?= $seed->getFamily() ?></p>
            <p class="planting-period"><span class="bold">Période de plantation : </span> <?= $planting_period ?></p>
            <p class="harvest-period"><span class="bold">Période de récolte : </span> <?= $harvest_period ?></p>
            <?php if ($image != null) : ?>
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
