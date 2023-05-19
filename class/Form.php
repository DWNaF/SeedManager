<?php

require_once dirname(__DIR__) . '/config/config.php';

class Form
{
    private static SeedDB $seedDB;

    public static function init(): void
    {
        if (!isset(self::$seedDB)) {
            self::$seedDB = new SeedDB();
        }
    }

    /**
     * Génère le formulaire de filtrage
     * @param array|null $filters Tableau associatif contenant les filtres
     */
    public static function renderFilterForm(?array $filters): void
    {
        self::init();
        $all_families = self::$seedDB->getAllFamilies();

        $selected_family = isset($filters['family']) ?  $filters['family'] : 'Toutes';
        $planting_min = isset($filters['planting_min']) ?  $filters['planting_min'] : 1;
        $planting_max = isset($filters['planting_max']) ?  $filters['planting_max'] : 12;

        $harvest_min = isset($filters['harvest_min']) ?  $filters['harvest_min'] : 1;
        $harvest_max = isset($filters['harvest_max']) ?  $filters['harvest_max'] : 12;

        $quantity_min = isset($filters['quantity_min']) ?  $filters['quantity_min'] : 0;
        $quantity_max = isset($filters['quantity_max']) ?  $filters['quantity_max'] : 9999999;

        $searchQuery = isset($filters['name']) ?  $filters['name'] : "";
?>
        <form id="filters_container" method="GET" action="">
            <div id="search_container">
                <label for="search">Recherche :</label>
                <input id="search" type="text" name="filters[name]" value="<?= $searchQuery ?>">
                <button type="submit"></button>
            </div>

            <div id="filters">
                <div class="filter_container">
                    <label for="family">Famille :</label>
                    <select id="family" name="filters[family]">
                        <option value="">Toutes</option>
                        <?php foreach ($all_families as $family) : ?>
                            <option value="<?= $family ?>" <?= $selected_family == $family ? 'selected' : '' ?>><?= $family ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter_container">
                    <label for="planting_min"><span class="bold">Période de plantation entre <span></label>
                    <select id="planting_min" name="filters[planting_min]">
                        <?php foreach (Calendar::MONTHS as $key => $month) : ?>
                            <option value="<?= $key ?>" <?= $key == $planting_min ? 'selected' : '' ?>>
                                <?= $month ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <label for="planting_max"> et </label>
                    <select id="planting_max" name="filters[planting_max]">
                        <?php foreach (Calendar::MONTHS as $key => $month) : ?>
                            <option value="<?= $key ?>" <?= $key == $planting_max ? 'selected' : '' ?>>
                                <?= $month ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter_container">
                    <label for="harvest_min"><span class="bold">Période de récolte entre <span></label>
                    <select id="harvest_min" name="filters[harvest_min]">
                        <?php foreach (Calendar::MONTHS as $key => $month) : ?>
                            <option value="<?= $key ?>" <?= $key == $harvest_min ? 'selected' : '' ?>>
                                <?= $month ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <label for="harvest_max"> et </label>
                    <select id="harvest_max" name="filters[harvest_max]">
                        <?php foreach (Calendar::MONTHS as $key => $month) : ?>
                            <option value="<?= $key ?>" <?= $key == $harvest_max ? 'selected' : '' ?>>
                                <?= $month ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    
                </div>
                
                <div class="filter_container">
                    <label for="quantity_min"><span class="bold">Stock<span> entre </label>
                    <input id="quantity_min" type="number" name="filters[quantity_min]" value="<?= $quantity_min ?>">
                    <label for="quantity_max"> et </label>
                    <input id="quantity_max" type="number" name="filters[quantity_max]" value="<?= $quantity_max ?>">
                </div>
                <button type="reset" form="filters_container" onclick="<?php unset($_GET["filters"]) ?>">Réinitialiser</button>
            </div>
            <?php if (isset($_SESSION["logged"]) && $_SESSION["logged"]) { ?>
                <a id="add_seed_btn" href="admin.php">Ajouter une graine</a>
            <?php } ?>
        </form>

    <?php
    }


    public static function renderSeedForm(Seed $seed = null): void
    {
        if (!empty($seed)) {
            $name = $seed->getName();
            $familyName = $seed->getFamily();
            $planting_period_min = $seed->getPlantingPeriodMin();
            $planting_period_max = $seed->getPlantingPeriodMax();
            $harvest_period_min = $seed->getHarvestPeriodMin();
            $harvest_period_max = $seed->getHarvestPeriodMax();
            $advices = $seed->getAdvices();
            $quantity = $seed->getQuantity();
        } else {
            $name = "";
            $familyName = "";
            $planting_period_min = 0;
            $planting_period_max = 12;
            $harvest_period_min = 0;
            $harvest_period_max = 12;
            $advices = "";
            $quantity = 0;
        }

    ?>
        <main>
            <h1>Ajout d'une graine</h1>
            <form action="<?= HANDLERS_PATH ?>addseed.php" method="POST" enctype="multipart/form-data">
                <label for="name">Nom :</label>
                <input type="text" id="name" name="name" value="<?= $name ?>" required>

                <label for="family">Famille :</label>
                <input list="families" type="text" id="family" name="family" value="<?= $familyName ?>" required>
                <datalist id="families">
                    <?php
                    $families = SeedDB::getAllFamilies();
                    foreach ($families as $family) {
                        echo "<option value=\"" . $family . "\">";
                    }
                    ?>
                </datalist>

                <label>Période de plantation</label>
                <div id="planting_perdiod_container">
                    <label for="planting_period_min">entre :</label>
                    <input type="number" id="planting_period_min" name="planting_period_min" min="1" max="12" value="<?= $planting_period_min ?>" required>
                    <label for="planting_period_max">et :</label>
                    <input type="number" id="planting_period_max" name="planting_period_max" min="1" max="12" value="<?= $planting_period_max ?>" required>
                </div>

                <label for="harvest_period">Période de récolte</label>
                <div id="harvest_period_container">
                    <label for="harvest_period_min">entre :</label>
                    <input type="number" id="harvest_period_min" name="harvest_period_min" min="1" max="12" value="<?= $harvest_period_min ?>" required>
                    <label for="harvest_period_max">et :</label>
                    <input type="number" id="harvest_period_max" name="harvest_period_max" min="1" max="12" value="<?= $harvest_period_max ?>" required>
                </div>

                <label for="advices">Conseils de culture :</label>
                <textarea id="advices" name="advices"><?= $advices ?></textarea>

                <label for="image">Image :</label>
                <input type="file" id="image" name="image">

                <label for="quantity">Quantité :</label>
                <input type="number" id="quantity" name="quantity" min="0" value="<?= $quantity ?>" required>

                <input type="submit" name="submit" value="Ajouter la graine">
            </form>
        </main>

<?php
    }



    /**
     * Upload une image
     * @param array $image Image à uploader
     * @return string|null nom de l'image si l'upload a réussi, null sinon
     */
    public static function uploadImage($image): ?string
    {
        $dossier_cible = SEEDS_ASSETS_PATH_FULL;
        $nom_fichier = $image['name'];
        $chemin_fichier = $dossier_cible . $nom_fichier;
        if (move_uploaded_file($image['tmp_name'], $chemin_fichier)) {
            return $nom_fichier;
        }
        return null;
    }
}
