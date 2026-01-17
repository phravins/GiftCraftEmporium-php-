<?php
require_once 'includes/db.php';

try {
    $db = Database::getConnection();

    // ensure categories exist (re-using IDs 1-4 from setup.php)
    // 1: Soft Toys, 2: Hampers, 3: Home Decor, 4: Wellness
    // Adding a few more categories if needed, or just reuse.
    // Let's stick to existing for simplicity or check/add.

    $new_products = [
        [1, 'Giant Panda Plush', 'An adorable giant panda plush toy for endless cuddles.', 45.00, 'assets/img/prod_teddy.png', 0],
        [1, 'Mini Bear Keychains', 'Set of 3 cure bear keychains.', 15.99, 'assets/img/prod_teddy.png', 0],

        [2, 'Spa Essentials Hamper', 'Luxury bath salts, soaps, and towels for a relaxing day.', 95.00, 'assets/img/prod_hamper.png', 1],
        [2, 'Fruit & Nut Basket', 'Healthy selection of dried fruits and nuts.', 55.00, 'assets/img/prod_hamper.png', 0],

        [3, 'Modern Ceramic Vase', 'Minimalist white ceramic vase for modern homes.', 42.00, 'assets/img/cat_home.png', 1],
        [3, 'Abstract Table Lamp', 'Artistic lamp that adds character to any room.', 120.00, 'assets/img/cat_home.png', 0],

        [4, 'Vanilla Bean Candle', 'Sweet and comforting vanilla scent.', 18.00, 'assets/img/prod_candle.png', 0],
        [4, 'Rose Petal Diffuser', 'Keep your room smelling fresh with rose essence.', 25.00, 'assets/img/prod_candle.png', 0],

        [3, 'Vintage Gold Frame', 'Classic gold-plated photo frame.', 38.00, 'assets/img/prod_frame.png', 0],
        [2, 'Tech Lover Gift Set', 'Headphones, power bank, and cables organizer.', 150.00, 'assets/img/cat_electronics.png', 1]
    ];

    $stmt = $db->prepare("INSERT INTO products (category_id, name, description, price, image_url, is_featured) VALUES (?, ?, ?, ?, ?, ?)");

    foreach ($new_products as $prod) {
        $stmt->execute($prod);
        echo "Added: {$prod[1]}<br>";
    }

    echo "Successfully added 10 new products.";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>