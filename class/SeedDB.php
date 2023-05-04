<?php

class SeedDB
{
    // Attribut(s)
    private static ?PDO $bd = null;

    public static function connect()
    {
        Database::log();
        self::$bd = Database::getDB();
    }

    public static function isConnected(): bool
    {
        return self::$bd != null;
    }

    /**
     * Récupère toutes les graines de la base de données
     * @return array|null Tableau contenant toutes les graines de la base de données sous forme d'instances de Seed
     */
    public static function getAllSeeds(): ?array
    {
        if (!self::isConnected()) {
            self::connect();
        };

        // Construction de la requête SQL
        $sql = "SELECT * FROM seeds";

        // Exécution de la requête SQL
        $statement = self::$bd->prepare($sql);
        if (!($statement->execute())) return null;
        $seeds = $statement->fetchAll(PDO::FETCH_CLASS, "Seed");

        return $seeds;
    }

    /**
     * Récupère toutes les graines de la base de données filtrées selon les critères spécifiés
     * @param array|null $filters Tableau associatif contenant les critères de filtres et leurs valeurs
     * @return array|null Tableau contenant toutes les graines de la base de données filtrées sous forme d'instances de Seed
     */
    public static function getFilteredSeeds(?array $filters): ?array
    {
        if (!self::isConnected()) {
            self::connect();
        };

        // Construction de la requête SQL
        $sql = "SELECT * FROM seeds WHERE 1=1";
        $params = array();

        if ($filters) {
            if (isset($filters['name'])) {
                $sql .= " AND name LIKE ?";
                $params[] = '%' . $filters['name'] . '%';
            }
            if (isset($filters['family'])) {
                $sql .= " AND family LIKE ?";
                $params[] = '%' . $filters['family'] . '%';
            }
            if (isset($filters['planting_period'])) {
                $sql .= " AND planting_period = ?";
                $params[] = $filters['planting_period'];
            }
            if (isset($filters['harvest_period'])) {
                $sql .= " AND harvest_period = ?";
                $params[] = $filters['harvest_period'];
            }
            if (isset($filters['advices'])) {
                $sql .= " AND advices LIKE ?";
                $params[] = '%' . $filters['advices'] . '%';
            }
            if (isset($filters['image'])) {
                $sql .= " AND image LIKE ?";
                $params[] = '%' . $filters['image'] . '%';
            }
            if (isset($filters['quantity'])) {
                $sql .= " AND quantity = ?";
                $params[] = $filters['quantity'];
            }
        }

        // Exécution de la requête SQL
        $statement = self::$bd->prepare($sql);
        if (!($statement->execute($params))) return null;
        $seeds = $statement->fetchAll(PDO::FETCH_CLASS, "Seed");

        return $seeds;
    }

    /**
     * Récupère toutes les familles de graines de la base de données
     */
    public static function getAllFamilies(): ?array
    {
        Database::log();
        $database = Database::getDB();

        if ($database == null) return null;
        $statement = $database->prepare("SELECT DISTINCT family FROM seeds");
        if (!($statement->execute())) return null;
        $families = $statement->fetchAll(PDO::FETCH_COLUMN);

        Database::disconnect();
        return $families;
    }


    /**
     * Récupère une graine de la base de données à partir de son identifiant unique
     * @param int $id L'identifiant de la graine à récupérer
     * @return Seed|null La graine récupérée, null si la graine n'existe pas
     */
    public static function getSeed(int $id): ?Seed
    {
        Database::log();
        $database = Database::getDB();

        if ($database == null) return null;
        $statement = $database->prepare("SELECT * FROM seeds WHERE id = ?");
        if (!($statement->execute([$id]))) return null;
        $seed = $statement->fetchObject("Seed");

        Database::disconnect();
        return $seed;
    }

    /**
     * Ajoute une nouvelle graine dans la base de données
     * @param Seed $seed La graine à ajouter
     * @return bool True si l'ajout s'est bien déroulé, False sinon
     */
    public static function addSeed(Seed $seed): bool
    {
        if (!self::isConnected()) {
            self::connect();
        };

        $statement = self::$bd->prepare("INSERT INTO seeds (name, family, planting_period, harvest_period, image, advices, quantity) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $result = $statement->execute([$seed->getName(), $seed->getFamily(), $seed->getPlantingPeriod(), $seed->getHarvestPeriod(), $seed->getImage(), $seed->getAdvices(), $seed->getQuantity()]);
        return $result;
    }

    /**
     * Supprime une graine de la base de données à partir de son identifiant
     * @param int $id L'identifiant de la graine à supprimer
     * @return bool True si la suppression s'est bien déroulée, False sinon
     */
    public static function deleteSeed(int $id): bool
    {
        if (!self::isConnected()) {
            self::connect();
        };

        $statement = self::$bd->prepare("DELETE FROM seeds WHERE id = ?");
        $result = $statement->execute([$id]);
        return $result;
    }

    /**
     * Met à jour la quantité de graines dans la base de données
     * @param int $id Identifiant de la graine à mettre à jour
     * @param int $newQuantity Nouvelle quantité de la graine
     * @return bool True si la mise à jour a été effectuée avec succès, false sinon
     */
    public static function updateSeedQuantity(int $id, int $newQuantity): bool
    {
        if (!self::isConnected()) {
            self::connect();
        };

        $statement = self::$bd->prepare("UPDATE seeds SET quantity = :quantity WHERE id = :id");
        $statement->bindValue(':quantity', $newQuantity, PDO::PARAM_INT);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        return $statement->execute();
    }
}
