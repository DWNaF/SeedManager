<?php

class Database
{

    private static ?PDO $bd = null;

    /**
     * Connexion à la base de données
     */
    public static function log(): void
    {
        if (self::$bd === null) {
            $configPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'login_db.ini';
            $config = parse_ini_file($configPath); // chemin vers le fichier de configuration de la base de données

            if ($config === false) return;
            try {
                self::$bd = new PDO("mysql:host=" . $config['host'] . ";dbname=" . $config['dbname'], $config['user'], $config['password']);
            } catch (PDOException $e) {
                return;
            }
        }
    }

    /**
     * Execute une requête SQL et retourne le résultat
     * @param string $query Requête SQL
     * @param array $params Paramètres de la requête
     */
    public static function query(string $query, array $params = []): ?PDOStatement
    {
        self::log();
        if (self::$bd === null) return null;
        $req = self::$bd->prepare($query);
        $req->execute($params);
        return $req;
    }

    /**
     * Déconnecte la base de données
     */
    public static function disconnect()
    {
        self::$bd = null;
    }

    /**
     * Renvoi le PDO connecté à la base de données.
     * @return PDO|null PDO connecté à la base de données
     */
    public static function getDB(): ?PDO
    {
        return self::$bd;
    }
}
