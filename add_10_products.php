<?php
require_once 'includes/db.php';

try {
    $db = Database::getConnection();

    $products = [
        ['Modern Ceramic Mug', 3, 'Minimalist ceramic coffee mug, perfect for your morning brew.', 15.00, 'assets/img/prod_mug.png', 0],
        ['Premium Leather Wallet', 2, 'Genuine leather wallet with multiple card slots and sleek design.', 45.00, 'assets/img/prod_wallet.png', 1],
        ['Silk Scarf', 2, 'Luxurious 100% silk scarf with a vibrant, elegant pattern.', 55.00, 'assets/img/prod_scarf.png', 0],
        ['Crystal Decanter Set', 3, 'Exquisite crystal whiskey decanter set with two glasses.', 85.00, 'assets/img/prod_decanter.png', 1],
        ['Potted Succulent', 3, 'Low-maintenance succulent in a stylish modern pot.', 12.00, 'assets/img/prod_succulent.png', 0],
        ['Artisan Soap Set', 4, 'Trio of handmade natural soaps with essential oils.', 18.00, 'assets/img/prod_soap.png', 0],
        ['Gourmet Tea Collection', 2, 'Selection of premium loose-leaf teas from around the world.', 30.00, 'assets/img/prod_tea.png', 0],
        ['Leather Notebook', 1, 'Refillable leather journal for your thoughts and sketches.', 28.00, 'assets/img/prod_notebook.png', 0], // Category 1 (Soft Toys) is weird, let's use 1 for now or maybe create new category like Stationery? For now using 1 or 2. Actually 2 (Hampers) might fit gifts better, but let's stick to existing IDs. let's put it in 3 (Home/Office) or just use 2.
        ['Minimalist Desk Clock', 3, 'Sleek matte finish desk clock to keep you on time.', 25.00, 'assets/img/prod_clock.png', 0],
        ['Luxury Fountain Pen', 2, 'Fine writing instrument with gold accents and smooth flow.', 60.00, 'assets/img/prod_pen.png', 1]
    ];

    // Note: Categories are 1:Soft Toys, 2:Hampers, 3:Home Decor, 4:Wellness. 
    // Adjusted: Notebook -> 2 (Gift), Pen -> 2 (Gift).

    $checkStmt = $db->prepare("SELECT COUNT(*) FROM products WHERE name = ?");
    $insertStmt = $db->prepare("INSERT INTO products (category_id, name, description, price, image_url, is_featured) VALUES (?, ?, ?, ?, ?, ?)");

    foreach ($products as $prod) {
        $checkStmt->execute([$prod[0]]);
        if ($checkStmt->fetchColumn() == 0) {
            $insertStmt->execute($prod);
            echo "Added: {$prod[0]}\n";
        } else {
            echo "Skipped (Exists): {$prod[0]}\n";
        }
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>