<?php
require_once 'includes/db.php';

try {
    $db = Database::getConnection();

    // Remove the specific product we just added
    $count = $db->exec("DELETE FROM products WHERE name = 'Premium Curated Gift Box'");

    if ($count > 0) {
        echo "Successfully removed 'Premium Curated Gift Box'.";
        // Also try to unlink the file if we want to be thorough, but PHP might not have permissions or we can do it via shell
    } else {
        echo "Product not found or already removed.";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>