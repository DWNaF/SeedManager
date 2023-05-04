<?php

class SeedDB
{
    // Attribut(s)
    private ?PDO $bd = null;

    // Constructeur
    public function __construct()
    {
        Database::log();
        $this->bd = Database::getDB();
    }

    /**
     * Récupère toutes les graines de la base de données
     * @return array|null Tableau contenant toutes les graines de la base de données sous forme d'instances de Seed
     */
    public function getAllSeeds(): ?array
    {
        if ($this->bd == null) return null;
        $statement = $this->bd->prepare("SELECT * FROM seeds");
        if (!($statement->execute())) return null;
        $seeds = $statement->fetchAll(PDO::FETCH_CLASS, "Seed");

        return $seeds;
    }


    /**
     * Récupère toutes les familles de graines de la base de données
     */
    public function getAllFamilies(): ?array
    {
        if ($this->bd == null) return null;
        $statement = $this->bd->prepare("SELECT DISTINCT family FROM seeds");
        if (!($statement->execute())) return null;
        $families = $statement->fetchAll(PDO::FETCH_COLUMN);

        return $families;
    }


    /**
     * Récupère une graine de la base de données à partir de son identifiant unique
     * @param int $id L'identifiant de la graine à récupérer
     * @return Seed|null La graine récupérée, null si la graine n'existe pas
     */
    public function getSeed(int $id): ?Seed
    {
        if ($this->bd == null) return null;
        $statement = $this->bd->prepare("SELECT * FROM seeds WHERE id = ?");
        if (!($statement->execute([$id]))) return null;
        $seed = $statement->fetchObject("Seed");

        return $seed;
    }

    /**
     * Ajoute une nouvelle graine dans la base de données
     * @param Seed $seed La graine à ajouter
     * @return bool True si l'ajout s'est bien déroulé, False sinon
     */
    public function addSeed(Seed $seed): bool
    {
        if ($this->bd == null) return false;
        $statement = $this->bd->prepare("INSERT INTO seeds (name, family, planting_period, harvest_period, image, advices, quantity) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $result = $statement->execute([$seed->getName(), $seed->getFamily(), $seed->getPlantingPeriod(), $seed->getHarvestPeriod(), $seed->getImage(), $seed->getAdvices(), $seed->getQuantity()]);
        return $result;
    }

    /**
     * Supprime une graine de la base de données à partir de son identifiant
     * @param int $id L'identifiant de la graine à supprimer
     * @return bool True si la suppression s'est bien déroulée, False sinon
     */
    public function deleteSeed(int $id): bool
    {
        if ($this->bd == null) return false;
        $statement = $this->bd->prepare("DELETE FROM seeds WHERE id = ?");
        $result = $statement->execute([$id]);
        return $result;
    }

    /**
     * Met à jour la quantité de graines dans la base de données
     * @param int $id Identifiant de la graine à mettre à jour
     * @param int $newQuantity Nouvelle quantité de la graine
     * @return bool True si la mise à jour a été effectuée avec succès, false sinon
     */
    public function updateSeedQuantity(int $id, int $newQuantity): bool
    {
        if ($this->bd == null) return false;

        $statement = $this->bd->prepare("UPDATE seeds SET quantity = :quantity WHERE id = :id");
        $statement->bindValue(':quantity', $newQuantity, PDO::PARAM_INT);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        return $statement->execute();
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
