<?php
require_once 'includes/db.php';

try {
    $db = Database::getConnection();

    // The original setup created 4 products.
    // We want to keep those and remove any added after (ID > 4).
    $count = $db->exec("DELETE FROM products WHERE id > 4");

    echo "Removed $count duplicate/new products. Catalog reverted to original unique items.";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>