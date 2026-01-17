<?php
require_once 'includes/db.php';

try {
    $db = Database::getConnection();

    $products_to_add = [
        [
            'name' => 'Silver Photo Frame',
            'category_id' => 3, // Home Decor
            'description' => 'Elegant silver-plated photo frame for your cherished memories.',
            'price' => 35.50,
            'image_url' => 'assets/img/prod_frame.png',
            'is_featured' => 1
        ],
        [
            'name' => 'Lavender Scented Candle',
            'category_id' => 4, // Wellness
            'description' => 'Relaxing lavender scented candle in a glass jar. 40 hours burn time.',
            'price' => 22.00,
            'image_url' => 'assets/img/prod_candle.png',
            'is_featured' => 0
        ]
    ];

    $checkStmt = $db->prepare("SELECT COUNT(*) FROM products WHERE name = ?");
    $insertStmt = $db->prepare("INSERT INTO products (category_id, name, description, price, image_url, is_featured) VALUES (?, ?, ?, ?, ?, ?)");

    foreach ($products_to_add as $prod) {
        $checkStmt->execute([$prod['name']]);
        if ($checkStmt->fetchColumn() == 0) {
            $insertStmt->execute([
                $prod['category_id'],
                $prod['name'],
                $prod['description'],
                $prod['price'],
                $prod['image_url'],
                $prod['is_featured']
            ]);
            echo "Added product: " . $prod['name'] . "\n";
        } else {
            echo "Product already exists: " . $prod['name'] . "\n";
        }
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>