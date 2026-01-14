<?php
class Database {
    private static $db;

    public static function getConnection() {
        if (!self::$db) {
            try {
                // Ensure the database file exists or will be created in the root directory
                self::$db = new PDO('sqlite:' . __DIR__ . '/../giftshop.db');
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Database Connection Error: " . $e->getMessage());
            }
        }
        return self::$db;
    }
}
?>
