<?php

require_once '../config/config.php';

// On vérifie que l'utilisateur est connecté et qu'il a bien accès à cette page
if (!isset($_SESSION["logged"]) || $_SESSION["logged"] == false) {
    header("Location: " . REL_PATH . "error");
    exit();
}


ob_start();

?>

<main>
    <h1>Ajout d'une graine</h1>
    <form action="<?= HANDLERS_PATH ?>addseed.php" method="POST" enctype="multipart/form-data">
        <label for="name">Nom :</label>
        <input type="text" id="name" name="name" required>

        <label for="family">Famille :</label>
        <input type="text" id="family" name="family" required>

        <label for="planting_period">Période de plantation :</label>
        <input type="text" id="planting_period" name="planting_period" required>

        <label for="harvest_period">Période de récolte :</label>
        <input type="text" id="harvest_period" name="harvest_period" required>

        <label for="advices">Conseils de culture :</label>
        <textarea id="advices" name="advices"></textarea>

        <label for="image">Image :</label>
        <input type="file" id="image" name="image">

        <label for="quantity">Quantité :</label>
        <input type="number" id="quantity" name="quantity" required>

        <input type="submit" name="submit" value="Ajouter la graine">
    </form>
</main>

<?php

$content = ob_get_clean();
Template::render($content, "admin");

?>