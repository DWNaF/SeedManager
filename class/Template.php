<?php

require_once dirname(__DIR__) . "/config/config.php";

class Template
{

    /**
     * Template de base pour les pages du site web (inclus un contenu entre le header et le footer)
     * @param string $content Contenu à afficher entre le header et le footer
     * @param string $page Nom de la page (utilisé pour le chargement des fichiers css et js)
     * @param string $meta_description Description de la page (utilisé pour le référencement)
     * @param bool $container Si vrai, le contenu est affiché dans un div avec l'id main_container
     * @return void Affiche l'HTML de la page
     */
    public static function render($content, $page, $container = true): void
    { ?>
        <!DOCTYPE html>
        <html lang="fr">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="icon" href="<?= ASSETS_PATH ?>fav.png" />
            <link rel="stylesheet" type="text/css" href="<?= CSS_PATH ?>root.css">
            <link rel="stylesheet" type="text/css" href="<?= CSS_PATH ?>header.css">
            <link rel="stylesheet" type="text/css" href="<?= CSS_PATH ?>footer.css">

            <?php if (file_exists(CSS_PATH_FULL . $page . '.css')) { ?>
                <link rel="stylesheet" type="text/css" href="<?= CSS_PATH . $page ?>.css">
            <?php } ?>

            <title><?= 'SeedManager' . ' - ' . ucfirst($page) ?></title>
        </head>

        <body>
            <?php include INCLUDES_PATH . 'header.php'; ?>

            <?php
            if ($container) {
            ?>
                <div id="main_container">
                    <?php echo $content; ?>
                </div>
            <?php
            } else echo $content
            ?>

            <?php include INCLUDES_PATH . 'footer.html'; ?>

            <script src="<?= JS_PATH ?>main.js"></script>
            <?php if (file_exists(JS_PATH_INCL . $page . '.js')) echo "<script src='" . JS_PATH . $page . ".js'></script>"; ?>
        </body>

        </html>
<?php
    }
}

?>