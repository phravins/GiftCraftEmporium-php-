<?php
$db = Database::getConnection();
$products = $db->query("SELECT * FROM products")->fetchAll();
?>

<div class="container mx-auto px-6 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800 font-serif mb-4">The Gallery</h1>
        <p class="text-gray-600 max-w-2xl mx-auto">Explore our collection in its purest form. Click any item to view it
            in 3D.</p>
        <div class="w-16 h-1 bg-indigo-600 mx-auto mt-6 rounded-full"></div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php foreach ($products as $product): ?>
            <a href="index.php?page=visualize&id=<?= $product['id'] ?>"
                class="group block overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-all duration-500 bg-white">
                <div class="relative h-64 overflow-hidden">
                    <img src="<?= htmlspecialchars($product['image_url']) ?>"
                        alt="<?= htmlspecialchars($product['name']) ?>"
                        class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700 ease-in-out">

                    <div
                        class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300 flex items-center justify-center">
                        <span
                            class="opacity-0 group-hover:opacity-100 bg-white text-gray-900 px-6 py-2 rounded-full font-bold transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 shadow-lg">
                            Visualise 3D
                        </span>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>