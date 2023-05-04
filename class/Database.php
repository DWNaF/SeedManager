<?php

class Database
{

    private static ?PDO $bd = null;

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

    public static function disconnect()
    {
        self::$bd = null;
    }

    public static function getDB(): ?PDO
    {
        return self::$bd;
    }
}
