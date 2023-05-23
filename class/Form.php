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
        <form id="simple_filter_form" class="filter_form" method="GET" action="">
            <?php if (isset($_SESSION["logged"]) && $_SESSION["logged"]) { ?>
                <a id="add_seed_btn" href="admin.php">New Seed</a>
            <?php } ?>
            <div id="search_container">
                <input id="search_input" type="text" name="filters[name]" placeholder="Rechercher une graine ..." value="<?= $searchQuery ?>">
                <button id="submit_simple_search" type="submit" form="simple_filter_form"></button>
            </div>
        </form>

        <form id="advanced_filter_form" class="filter_form" method="GET" action="">
            <button id="show_filters" type="button">Recherche avancée +</button>
            <dialog class="hidden filters" id="modal">
                <div class="filter_container">
                    <label for="search_input">Recherche :</label>
                    <input type="text" name="filters[name]" placeholder="Rechercher une graine ..." value="<?= $searchQuery ?>">
                </div>
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
                    <label for="planting_min">Période de plantation entre</label>
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
                    <label for="harvest_min">Période de récolte entre</label>
                    <select id="harvest_min" name="filters[harvest_min]">
                        <?php foreach (Calendar::MONTHS as $key => $month) : ?>
                            <option value="<?= $key ?>" <?= $key == $harvest_min ? 'selected' : '' ?>>
                                <?= $month ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <label for="harvest_max">et</label>
                    <select id="harvest_max" name="filters[harvest_max]">
                        <?php foreach (Calendar::MONTHS as $key => $month) : ?>
                            <option value="<?= $key ?>" <?= $key == $harvest_max ? 'selected' : '' ?>>
                                <?= $month ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                </div>

                <div class="filter_container">
                    <label for="quantity_min">Stock entre</label>
                    <input id="quantity_min" type="number" min=0 name="filters[quantity_min]" value="<?= $quantity_min ?>">
                    <label for="quantity_max"> et </label>
                    <input id="quantity_max" type="number" min=0 name="filters[quantity_max]" value="<?= $quantity_max ?>">
                </div>

                <div class="modal_btns_container">
                    <button type="reset" form="advanced_filter_form" onclick="resetFilters()">Réinitialiser</button>
                    <script>
                        function resetFilters() {
                            window.location.href = window.location.pathname;
                        }
                    </script>
                </div>

            </dialog>

        </form>
    <?php
    }

    public static function renderSeedForm(Seed $seed = null): void
    {
        if (!empty($seed)) {
            $id = $seed->getId();
            $name = $seed->getName();
            $familyName = $seed->getFamily();
            $planting_period_min = $seed->getPlantingPeriodMin();
            $planting_period_max = $seed->getPlantingPeriodMax();
            $harvest_period_min = $seed->getHarvestPeriodMin();
            $harvest_period_max = $seed->getHarvestPeriodMax();
            $advices = $seed->getAdvices();
            $quantity = $seed->getQuantity();
            $image = $seed->getImage();
        } else {
            $id = -1;
            $name = "";
            $familyName = "";
            $planting_period_min = 0;
            $planting_period_max = 12;
            $harvest_period_min = 0;
            $harvest_period_max = 12;
            $advices = "";
            $quantity = 0;
            $image = null;
        }

    ?>
        <main>
            <?php
            if (!empty($seed)) {
                echo "<h1>Modification de la graine : " . $seed->getName() . "</h1>";
            } else {
                echo "<h1>Ajout d'une graine</h1>";
            }
            ?>
            <form action="<?= HANDLERS_PATH . (empty($seed) ? 'addseed' : 'editseed') . '.php' ?>" method="POST" enctype="multipart/form-data">
                <label for="name">Nom :</label>
                <input type="text" id="name" name="name" value="<?= $name ?>" required>

                <label for="family">Famille :</label>
                <input list="families" type="text" id="family" name="family" value="<?= $familyName ?>" required>
                <datalist id="families" aria-autocomplete="off">
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
                <?php if (!empty($image)) { ?>
                    <img id="image_preview" src="<?= SEEDS_ASSETS_PATH . $image ?>" alt="Image de la graine">
                <?php } ?>
                <input type="file" id="image" name="image">
                <?php if (empty($image)) { ?>
                    <img id="new_image_preview">
                <?php } ?>

                <label for="quantity">Quantité (g) :</label>
                <input type="number" id="quantity" name="quantity" min="0" value="<?= $quantity?>" required>

                <input type="hidden" name="id" value="<?= $id ?>">
                <input type="submit" name="submit" value="<?= !empty($seed) ? "Modifier la graine" : "Ajouter la graine" ?>">
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
        if ($image['error'] != 0) {
            return null;
        }
        $dossier_cible = SEEDS_ASSETS_PATH_FULL;
        $nom_fichier = $image['name'];
        $chemin_fichier = $dossier_cible . $nom_fichier;
        if (move_uploaded_file($image['tmp_name'], $chemin_fichier)) {
            return $nom_fichier;
        }
        return null;
    }
}
