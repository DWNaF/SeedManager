<?php

require_once dirname(__DIR__) . '/config/config.php';

class SeedDB
{
    // Attribut(s)
    private ?PDO $db = null;

    /**
     * Constructeur de la classe SeedDB qui permet de se connecter à la base de données
     */
    public function __construct()
    {
        Database::log();
        $this->db = Database::getDB();
    }

    /**
     * Vérifie si la base de données est bien connectée
     * @return bool true si la base de données est connectée, false sinon
     */
    public function isConnected(): bool
    {
        return $this->db !== null;
    }


    /**
     * Récupère toutes les graines de la base de données
     * @return array|null Tableau contenant toutes les graines de la base de données sous forme d'instances de Seed
     */
    public function getAllSeeds(): ?array
    {
        if (!$this->isConnected()) return null;

        // Construction de la requête SQL
        $sql = "SELECT * FROM seeds";

        // Exécution de la requête SQL
        $statement = $this->db->query($sql);
        $seeds = $statement->fetchAll(PDO::FETCH_CLASS, "Seed");

        return $seeds;
    }


    /**
     * Récupère toutes les graines de la base de données filtrées selon les critères spécifiés
     * @param array|null $filters Tableau associatif contenant les critères de filtres et leurs valeurs
     * @return array|null Tableau contenant toutes les graines de la base de données filtrées sous forme d'instances de Seed
     */
    public function getFilteredSeeds(?array $filters): ?array
    {
        if (!$this->isConnected()) return null;

        // Construction de la requête SQL
        $sql = "SELECT * FROM seeds WHERE 1=1";
        $params = array();

        if ($filters) {
            if (isset($filters['name'])) {
                $sql .= " AND seeds_name LIKE ?";
                $params[] = '%' . $filters['name'] . '%';
            }
            if (isset($filters['family'])) {
                $sql .= " AND family_id IN (SELECT family_id FROM families WHERE family_name LIKE ?)";
                $params[] = '%' . $filters['family'] . '%';
            }
            // Ajoutez d'autres conditions de filtre si nécessaire
        }

        // Exécution de la requête SQL
        $statement = $this->db->prepare($sql);
        $statement->execute($params);
        $seeds = $statement->fetchAll(PDO::FETCH_CLASS, "Seed");

        return $seeds;
    }

    /**
     * Récupère toutes les familles de graines de la base de données
     */
    public function getAllFamilies(): ?array
    {
        Database::log();
        $database = Database::getDB();

        if ($database == null) return null;
        $statement = $database->prepare("SELECT DISTINCT family_name FROM families");
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
    public function getSeed(int $id): ?Seed
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
    public function addSeed(Seed $seed): bool
    {
        if (!$this->isConnected()) return false;

        $query = "INSERT INTO seeds (seeds_name, family_id, planting_period_min, planting_period_max, harvest_period_min, harvest_period_max, advices, image, quantity) VALUES (:name, :family_id, :planting_period_min, :planting_period_max, :harvest_period_min, :harvest_period_max, :advices, :image, :quantity)";
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
        if (!$this->isConnected()) return false;

        $query = "DELETE FROM seeds WHERE id = :id";
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
        if (!$this->isConnected()) return false;

        $query = "UPDATE seeds SET quantity = :quantity WHERE id = :id";
        $params = array(':quantity' => $newQuantity, ':id' => $id);

        $result = Database::query($query, $params);

        return ($result !== null);
    }


    /**
     * Récupère l'identifiant d'une famille de graines à partir de son nom si elle existe
     * @param string $family_name Nom de la famille de graines
     * @return int|null L'identifiant de la famille de graines, null si elle n'existe pas
     */
    public static function getFamilyId($family_name) : int|null {
        Database::log();
        $database = Database::getDB();

        if ($database == null) return null;
        $statement = $database->prepare("SELECT family_id FROM families WHERE family_name = ?");
        if (!($statement->execute([$family_name]))) return null;
        $family_id = $statement->fetchColumn();

        Database::disconnect();
        return $family_id;
    }

    /**
     * Récupère le nom d'une famille de graines à partir de son identifiant si elle existe
     * @param int $family_id Identifiant de la famille de graines
     * @return string|null Le nom de la famille de graines, null si elle n'existe pas
     */
    public static function getFamilyName($family_id) : string|null {
        Database::log();
        $database = Database::getDB();

        if ($database == null) return null;
        $statement = $database->prepare("SELECT family_name FROM families WHERE family_id = ?");
        if (!($statement->execute([$family_id]))) return null;
        $family_name = $statement->fetchColumn();

        Database::disconnect();
        return $family_name;
    }
}
