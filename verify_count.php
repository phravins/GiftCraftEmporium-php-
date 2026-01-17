<?php
require_once 'includes/db.php';
try {
    $db = Database::getConnection();
    $c = $db->query("SELECT COUNT(*) FROM products")->fetchColumn();
    echo "Total Products: " . $c;
} catch (Exception $e) {
    echo $e->getMessage();
}
?>