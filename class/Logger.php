<?php

require_once dirname(__DIR__) . "/config/config.php";

class Logger
{

    private static ?PDO $db;

    public static function generateLogger($csrf_token)
    {
?>
        <form id="log_form" action="" method="post">
            <span>
                <h2>Please login</h2>
            </span>
            <input type="text" name="login" placeholder="Enter your login" required>
            <input type="password" name="password" placeholder="Enter your password" required>
            <!-- Ajouter le jeton CSRF en tant que champ caché -->
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            <button type="submit">Login</button>
        </form>
<?php
    }

    /**
     * Vérifie si l'utilisateur existe et si le mot de passe correspond
     * @param string|null $username
     * @param string|null $password
     * @return bool true si l'utilisateur existe et si le mot de passe correspond, false sinon
     */
    public static function log(?string $username, ?string $password): bool
    {
        Database::log();
        self::$db = Database::getDB();
        if (self::$db === null) return false;

        // Vérifier si la table "users" existe
        $stmt = self::$db->query("SHOW TABLES LIKE 'users'");
        if ($stmt->rowCount() == 0) {
            Database::disconnect();
            return false;
        }

        // Préparer la requête pour récupérer les informations de l'utilisateur
        $stmt = self::$db->prepare('SELECT password, salt FROM users WHERE username = ?');
        $result = $stmt->execute([$username]);
        if (!$result) {
            Database::disconnect();
            return false;
        }

        // Récupérer le résultat de la requête
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();

        // Vérifier si l'utilisateur existe et si le mot de passe correspond
        if ($user && password_verify($password . $user['salt'], $user['password'])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Ajoute un utilisateur à la base de données
     * ! Bien évidemment c'est juste pour le debug, il ne faut pas laisser cette fonction dans le code final
     * @param string $username 
     * @param string $password
     * @return bool true si l'utilisateur a été ajouté, false sinon
     */
    public static function addUser(string $username, string $password): bool
    {
        $salt = bin2hex(random_bytes(32)); // Génère une chaîne aléatoire de 64 caractères hexadécimaux
        $passwordHash = password_hash($password . $salt, PASSWORD_DEFAULT);

        Database::log();
        self::$db = Database::getDB();
        if (self::$db === null) return false;

        $stmt = self::$db->prepare('INSERT INTO users (username, password, salt) VALUES (?, ?, ?)');
        $result = $stmt->execute([$username, $passwordHash, $salt]);

        Database::disconnect();

        return $result;
    }
}
