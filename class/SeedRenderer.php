<?php

require_once '../config/config.php';
if (session_status() != PHP_SESSION_ACTIVE) session_start();

class SeedRenderer
{

    public static function renderAll(array $seeds, ?string $selectedFamily = null, ?string $searchQuery = null): void
    {
?>
        <div id="seeds_container">
            <?php
            foreach ($seeds as $seed) {
                if (($selectedFamily === null || $selectedFamily === $seed->getFamily() || $selectedFamily == 'Toutes') &&
                    ($searchQuery === null || stripos($seed->getName(), $searchQuery) !== false)
                ) {
                    self::renderSeed($seed);
                }
            }

            ?>
        </div>
    <?php
    }

    public static function renderSeed(Seed $seed): void
    {
    ?>
        <div class="seed">
            <h2 class="name"><?= $seed->getName() ?></h2>
            <p class="family light_text"><?= $seed->getFamily() ?></p>
            <p class="planting-period"><span class="bold">Période de plantation : </span> <?= $seed->getPlantingPeriod() ?></p>
            <p class="harvest-period"><span class="bold">Période de récolte : </span> <?= $seed->getHarvestPeriod() ?></p>
            <?php if ($seed->getImage()) : ?>
                <img class="image" src="<?= $seed->getImage() ?>" alt="<?= $seed->getName() ?>">
            <?php endif; ?>
            <p class="advices"><span class="bold">Conseils : </span><?= $seed->getAdvices() ?></p>
            <p class="quantity"><span class="bold">Stock : </span><?= $seed->getQuantity() ?></p>
            <?php if (isset($_SESSION["logged"]) && $_SESSION["logged"]) { ?>
                <div class="actions">
                    <a class="admin_buttons" href="<?= PUBLIC_PATH ?>editSeed.php?id=<?= $seed->getId() ?>">Modifier</a>
                    <a class="admin_buttons" href="<?= HANDLERS_PATH ?>deleteseed.php?id=<?= $seed->getId() ?>">Supprimer</a>
                </div>
                <?php } ?>
        </div>
    <?php
    }


    /**
     * Affiche le formulaire de filtre des graines
     */
    public static function renderFilterForm(array $families, ?string $searchQuery = null): void
    {
    ?>
        <form id="filter_container" method="GET" action="">
            <div class="filters">
                <label for="family">Famille :</label>
                <select id="family" name="family">
                    <option value="Toutes">Toutes</option>
                    <?php foreach ($families as $family) : ?>
                        <option value="<?= $family ?>" <?= (isset($_GET['family']) && $family === $_GET['family'] ? 'selected' : '') ?>><?= $family ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="search">Recherche :</label>
                <input id="search" type="text" name="search" value="<?= $searchQuery ?? '' ?>">
                <button type="submit">Filtrer</button>
            </div>
            <?php if (isset($_SESSION["logged"]) && $_SESSION["logged"]) { ?>
                <a id="add_seed_btn" href="addSeed.php">Ajouter une graine</a>
            <?php } ?>
        </form>

<?php
    }
}
