<?php
require_once 'includes/db.php';

try {
    $db = Database::getConnection();

    $stmt = $db->prepare("INSERT INTO products (category_id, name, description, price, image_url, is_featured) VALUES (?, ?, ?, ?, ?, ?)");

    $stmt->execute([2, 'Premium Curated Gift Box', 'A special hand-picked selection of our finest items.', 120.00, 'assets/img/prod_hamper.png', 1]);

    echo "Added single unique product: Premium Curated Gift Box";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>