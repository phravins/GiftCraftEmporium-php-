<?php
require_once 'includes/db.php';

try {
    $db = Database::getConnection();
    
    // Users Table (Login with Name + Phone)
    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        phone TEXT UNIQUE NOT NULL,
        address TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Admins Table (Login with Name + Password)
    $db->exec("CREATE TABLE IF NOT EXISTS admins (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT UNIQUE NOT NULL,
        password TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Categories
    $db->exec("CREATE TABLE IF NOT EXISTS categories (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        description TEXT
    )");

    // Products
    $db->exec("CREATE TABLE IF NOT EXISTS products (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        category_id INTEGER,
        name TEXT NOT NULL,
        description TEXT,
        price REAL NOT NULL,
        image_url TEXT,
        is_featured INTEGER DEFAULT 0,
        FOREIGN KEY(category_id) REFERENCES categories(id)
    )");

    // Cart (Persistent)
    $db->exec("CREATE TABLE IF NOT EXISTS carts (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER,
        product_id INTEGER,
        quantity INTEGER DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY(user_id) REFERENCES users(id),
        FOREIGN KEY(product_id) REFERENCES products(id)
    )");

    // Orders
    $db->exec("CREATE TABLE IF NOT EXISTS orders (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER,
        total_amount REAL NOT NULL,
        status TEXT DEFAULT 'pending', -- pending, dispatched, completed
        shipping_address TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY(user_id) REFERENCES users(id)
    )");

    // Order Items
    $db->exec("CREATE TABLE IF NOT EXISTS order_items (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        order_id INTEGER,
        product_id INTEGER,
        quantity INTEGER,
        price REAL,
        FOREIGN KEY(order_id) REFERENCES orders(id),
        FOREIGN KEY(product_id) REFERENCES products(id)
    )");

    // Reviews
    $db->exec("CREATE TABLE IF NOT EXISTS reviews (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER,
        product_id INTEGER,
        rating INTEGER,
        comment TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY(user_id) REFERENCES users(id),
        FOREIGN KEY(product_id) REFERENCES products(id)
    )");

    // Seed Admin (admin / admin123)
    // Using simple password_hash
    $stmt = $db->prepare("SELECT COUNT(*) FROM admins WHERE username = 'admin'");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $pass = password_hash('admin123', PASSWORD_DEFAULT);
        $db->exec("INSERT INTO admins (username, password) VALUES ('admin', '$pass')");
        echo "Admin created. User: admin, Pass: admin123<br>";
    }

    // Seed Categories
    $cats = ['Soft Toys', 'Hampers', 'Home Decor', 'Wellness'];
    foreach ($cats as $c) {
        $db->exec("INSERT OR IGNORE INTO categories (name) VALUES ('$c')");
    }

    // Seed Sample Products
    $stmt = $db->prepare("SELECT COUNT(*) FROM products");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $db->exec("INSERT INTO products (category_id, name, description, price, image_url, is_featured) VALUES 
            (1, 'Cuddly Teddy Bear', 'Soft and fluffy teddy bear with a red ribbon. Perfect for hugs.', 29.99, 'assets/img/prod_teddy.png', 1),
            (2, 'Luxury Chocolate Hamper', 'Assorted gourmet chocolates and treats in a beautiful basket.', 85.00, 'assets/img/prod_hamper.png', 1),
            (3, 'Silver Photo Frame', 'Elegant silver-plated photo frame for your cherished memories.', 35.50, 'assets/img/prod_frame.png', 1),
            (4, 'Lavender Scented Candle', 'Relaxing lavender scented candle in a glass jar. 40 hours burn time.', 22.00, 'assets/img/prod_candle.png', 0)
        ");
        echo "Sample products created.<br>";
    }

    echo "Database setup completed successfully.";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
