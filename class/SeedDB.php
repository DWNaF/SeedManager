<?php

require_once dirname(__DIR__) . '/config/config.php';

class SeedDB
{

    /**
     * Récupère toutes les graines de la base de données
     * @return array|null Tableau contenant toutes les graines de la base de données sous forme d'instances de Seed
     */
    public static function getAllSeeds(): ?array
    {
        if (!Database::isConnected()) {
            Database::log(); // Se connecte à la base de données si ce n'est pas déjà fait
        }

        // Construction de la requête SQL
        $query = "SELECT * FROM seeds";
        $query = Database::query($query);

        $seeds = $query->fetchAll(PDO::FETCH_CLASS, "Seed");

        return $seeds;
    }


    /**
     * Récupère toutes les graines de la base de données filtrées selon les critères spécifiés
     * @param array|null $filters Tableau associatif contenant les critères de filtres et leurs valeurs
     * @return array|null Tableau contenant toutes les graines de la base de données filtrées sous forme d'instances de Seed
     */
    public static function getFilteredSeeds(?array $filters): ?array
    {
        if (!Database::isConnected()) {
            Database::log(); // Se connecte à la base de données si ce n'est pas déjà fait
        }

        // Construction de la requête SQL
        $sql = "SELECT * FROM seeds WHERE 1=1";
        $params = array();

        if ($filters) {
            if (isset($filters['name'])) {
                $sql .= " AND seed_name LIKE ?";
                $params[] = '%' . $filters['name'] . '%';
            }
            if (isset($filters['family'])) {
                $sql .= " AND family_id IN (SELECT family_id FROM families WHERE family_name LIKE ?)";
                $params[] = '%' . $filters['family'] . '%';
            }
        }

        // Exécution de la requête SQL
        $result = Database::query($sql, $params);
        $result = $result->fetchAll(PDO::FETCH_CLASS, "Seed");

        return $result;
    }

    /**
     * Récupère toutes les familles de graines de la base de données
     */
    public static function getAllFamilies(): ?array
    {
        if (!Database::isConnected()) {
            Database::log(); // Se connecte à la base de données si ce n'est pas déjà fait
        }

        $sql = "SELECT DISTINCT family_name FROM families";
        $result = Database::query($sql);
        $result = $result->fetchAll(PDO::FETCH_COLUMN);

        return $result;
    }


    /**
     * Récupère une graine de la base de données à partir de son identifiant unique
     * @param int $id L'identifiant de la graine à récupérer
     * @return Seed|null La graine récupérée, null si la graine n'existe pas
     */
    public static function getSeed(?int $id): ?Seed
    {
        if (!Database::isConnected()) {
            Database::log(); // Se connecte à la base de données si ce n'est pas déjà fait
        }

        if ($id === null) {
            return null;
        }

        $sql = "SELECT * FROM seeds WHERE seed_id = ?";
        $params = array($id);
        $result = Database::query($sql, $params);
        $result = $result->fetchObject("Seed");

        return ($result !== false) ? $result : null;
    }

    /**
     * Ajoute une nouvelle graine dans la base de données
     * @param Seed $seed La graine à ajouter
     * @return bool True si l'ajout s'est bien déroulé, False sinon
     */
    public static function addSeed(Seed $seed): bool
    {
        if (!Database::isConnected()) {
            Database::log(); // Se connecte à la base de données si ce n'est pas déjà fait
        }

        $query = "INSERT INTO seeds (seed_name, family_id, planting_period_min, planting_period_max, harvest_period_min, harvest_period_max, advices, image, quantity) VALUES (:name, :family_id, :planting_period_min, :planting_period_max, :harvest_period_min, :harvest_period_max, :advices, :image, :quantity)";
        $params = array(
            ':name' => $seed->getName(),
            ':family_id' => SeedDB::getFamilyId($seed->getFamily()),
            ':planting_period_min' => $seed->getPlantingPeriodMin(),
            ':planting_period_max' => $seed->getPlantingPeriodMax(),
            ':harvest_period_min' => $seed->getHarvestPeriodMin(),
            ':harvest_period_max' => $seed->getHarvestPeriodMax(),
            ':advices' => $seed->getAdvices(),
            ':image' => $seed->getImage(),
            ':quantity' => $seed->getQuantity()
        );

        $result = Database::query($query, $params);

        return ($result !== null);
    }

    /**
     * Supprime une graine de la base de données à partir de son identifiant
     * @param int $id L'identifiant de la graine à supprimer
     * @return bool True si la suppression s'est bien déroulée, False sinon
     */
    public function deleteSeed(int $id): bool
    {
        if (!Database::isConnected()) {
            Database::log(); // Se connecte à la base de données si ce n'est pas déjà fait
        }

        $query = "DELETE FROM seeds WHERE seed_id = :id";
        $params = array(':id' => $id);

        $result = Database::query($query, $params);

        return ($result !== null);
    }

    /**
     * Met à jour la quantité de graines dans la base de données
     * @param int $id Identifiant de la graine à mettre à jour
     * @param int $newQuantity Nouvelle quantité de la graine
     * @return bool True si la mise à jour a été effectuée avec succès, false sinon
     */
    public function updateSeedQuantity(int $id, int $newQuantity): bool
    {
        if (!Database::isConnected()) {
            Database::log(); // Se connecte à la base de données si ce n'est pas déjà fait
        }

        $query = "UPDATE seeds SET quantity = :quantity WHERE seed_id = :id";
        $params = array(':quantity' => $newQuantity, ':id' => $id);

        $result = Database::query($query, $params);

        return ($result !== null);
    }


    /**
     * Récupère l'identifiant d'une famille de graines à partir de son nom si elle existe
     * @param string $family_name Nom de la famille de graines
     * @return int|null L'identifiant de la famille de graines, null si elle n'existe pas
     */
    public static function getFamilyId($family_name): int|null
    {
        if (!Database::isConnected()) {
            Database::log(); // Se connecte à la base de données si ce n'est pas déjà fait
        }

        $sql = "SELECT family_id FROM families WHERE family_name = ?";
        $params = array($family_name);
        $result = Database::query($sql, $params);
        $result = $result->fetchColumn();

        return $result;
    }

    /**
     * Récupère le nom d'une famille de graines à partir de son identifiant si elle existe
     * @param int $family_id Identifiant de la famille de graines
     * @return string|null Le nom de la famille de graines, null si elle n'existe pas
     */
    public static function getFamilyName($family_id): string|null
    {
        if (!Database::isConnected()) {
            Database::log(); // Se connecte à la base de données si ce n'est pas déjà fait
        }

        $sql = "SELECT family_name FROM families WHERE family_id = ?";
        $params = array($family_id);
        $result = Database::query($sql, $params);
        $result = $result->fetchColumn();

        return $result;
    }

    /**
     * Ajoute une nouvelle famille de graines dans la base de données
     * @param string $family_name Nom de la famille de graines à ajouter
     * @return bool True si l'ajout s'est bien déroulé, False sinon
     */
    public static function addFamily($family_name): bool
    {
        if (!Database::isConnected()) {
            Database::log(); // Se connecte à la base de données si ce n'est pas déjà fait
        }

        $query = "INSERT INTO families (family_name) VALUES (:family_name)";
        $params = array(':family_name' => $family_name);

        $result = Database::query($query, $params);

        return ($result !== null);
    }

    /**
     * Mets à jour une graine dans la base de données
     * @param int $seed_id Identifiant de la graine à mettre à jour
     * @param string|null $seed_name Nom de la graine
     * @param int|null $family_id Identifiant de la famille de la graine
     * @param int|null $planting_period_min Période de plantation minimale de la graine
     * @param int|null $planting_period_max Période de plantation maximale de la graine
     * @param int|null $harvest_period_min Période de récolte minimale de la graine
     * @param int|null $harvest_period_max Période de récolte maximale de la graine
     * @param string|null $advices Conseils pour la graine
     * @param string|null $image Chemin de l'image de la graine
     * @param int|null $quantity Quantité de la graine
     * @return bool True si la mise à jour s'est bien déroulée, False sinon
     */
    public static function updateSeed($seed_id, $seed_name, $family_id, $planting_period_min, $planting_period_max, $harvest_period_min, $harvest_period_max, $advices, $image, $quantity): bool
    {
        $query = "UPDATE seeds SET ";
        $params = [];

        if ($seed_name != null && !empty($seed_name)) {
            $query .= "seed_name = :seed_name, ";
            $params[':seed_name'] = $seed_name;
        }

        if ($family_id != null && !empty($family_id)) {
            $query .= "family_id = :family_id, ";
            $params[':family_id'] = $family_id;
        }

        if ($planting_period_min != null && !empty($planting_period_min)) {
            $query .= "planting_period_min = :planting_period_min, ";
            $params[':planting_period_min'] = $planting_period_min;
        }

        if ($planting_period_max != null && !empty($planting_period_max)) {
            $query .= "planting_period_max = :planting_period_max, ";
            $params[':planting_period_max'] = $planting_period_max;
        }

        if ($harvest_period_min != null && !empty($harvest_period_min)) {
            $query .= "harvest_period_min = :harvest_period_min, ";
            $params[':harvest_period_min'] = $harvest_period_min;
        }

        if ($harvest_period_max != null && !empty($harvest_period_max)) {
            $query .= "harvest_period_max = :harvest_period_max, ";
            $params[':harvest_period_max'] = $harvest_period_max;
        }

        if ($advices != null && !empty($advices)) {
            $query .= "advices = :advices, ";
            $params[':advices'] = $advices;
        }

        if ($image != null && !empty($image)) {
            $query .= "image = :image, ";
            $params[':image'] = $image;
        }

        if ($quantity != null && !empty($quantity)) {
            $query .= "quantity = :quantity, ";
            $params[':quantity'] = $quantity;
        }

        $query = rtrim($query, ', ');
        $query .= " WHERE seed_id = :seed_id";
        $params[':seed_id'] = $seed_id;

        $result = Database::query($query, $params);

        return $result !== null;
    }

    /**
     * Récupère toutes les images utilisées pour les graines
     * @return array|null Les images utilisées pour les graines
     */
    public static function getSeedsImages(): array|null
    {
        $query = "SELECT DISTINCT image FROM seeds";
        $result = Database::query($query);

        return $result->fetchAll();
    }
}
