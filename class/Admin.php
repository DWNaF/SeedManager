<?php

require_once dirname(__DIR__) . '/config/config.php';


class Admin
{

    /**
     * Supprime les images qui ne sont plus utilisées
     */
    public static function deleteUnusedImages()
    {
        $used_images = SeedDB::getSeedsImages();
        $images = scandir(SEEDS_ASSETS_PATH_FULL);
        foreach ($images as $image) {
            if ($image != "." && $image != ".." && $image != "unavailable.png") {
                $found = false;
                foreach ($used_images as $used_image) {
                    if ($image == $used_image["image"]) {
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    unlink(SEEDS_ASSETS_PATH_FULL . $image);
                }
            }
        }
    }
}
