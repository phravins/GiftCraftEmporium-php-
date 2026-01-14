<?php
$db = Database::getConnection();
$products = $db->query("SELECT * FROM products")->fetchAll();
?>

<!-- Hero Section -->
<div class="relative bg-gray-900 rounded-3xl overflow-hidden mb-16 shadow-2xl h-[500px]">
    <img src="assets/img/hero_banner.png" alt="Gift Shop Interior" class="absolute inset-0 w-full h-full object-cover opacity-60">
    <div class="relative z-10 flex flex-col justify-center items-center h-full text-center px-4">
        <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 tracking-tight drop-shadow-lg font-serif">The Art of Gifting</h1>
        <p class="text-xl md:text-2xl text-gray-100 max-w-3xl mx-auto font-light leading-relaxed drop-shadow-md">Curated collections for every occasion. Find the perfect piece that speaks from the heart.</p>
        <a href="#products" class="mt-8 bg-white text-gray-900 px-8 py-3 rounded-full font-bold hover:bg-gray-100 transition shadow-lg transform hover:-translate-y-1">Explore Collection</a>
    </div>
</div>

<!-- Departments / Categories -->
<div class="mb-16">
    <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center font-serif">Shop by Department</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="relative rounded-2xl overflow-hidden group shadow-lg cursor-pointer h-80">
            <img src="assets/img/cat_home.png" alt="Home Decor" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
            <div class="absolute inset-0 bg-black bg-opacity-30 group-hover:bg-opacity-40 transition items-center justify-center flex">
                <h3 class="text-3xl font-bold text-white tracking-widest uppercase border-b-2 border-white pb-2">Home Decor</h3>
            </div>
        </div>
        <div class="relative rounded-2xl overflow-hidden group shadow-lg cursor-pointer h-80">
            <img src="assets/img/cat_electronics.png" alt="Electronics" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
            <div class="absolute inset-0 bg-black bg-opacity-30 group-hover:bg-opacity-40 transition items-center justify-center flex">
                <h3 class="text-3xl font-bold text-white tracking-widest uppercase border-b-2 border-white pb-2">Electronics</h3>
            </div>
        </div>
        <div class="relative rounded-2xl overflow-hidden group shadow-lg cursor-pointer h-80">
            <img src="assets/img/cat_fashion.png" alt="Fashion" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
            <div class="absolute inset-0 bg-black bg-opacity-30 group-hover:bg-opacity-40 transition items-center justify-center flex">
                <h3 class="text-3xl font-bold text-white tracking-widest uppercase border-b-2 border-white pb-2">Fashion</h3>
            </div>
        </div>
    </div>
</div>

<div id="products" class="mb-8 text-center">
    <h2 class="text-3xl font-bold text-gray-800 font-serif">Featured Products</h2>
    <div class="w-24 h-1 bg-indigo-600 mx-auto mt-4 rounded-full"></div>
</div>

<!-- Product Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
    <?php foreach ($products as $product): ?>
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex flex-col group">
        <div class="relative overflow-hidden h-56">
             <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
             <?php if ($product['is_featured']): ?>
                <span class="absolute top-4 left-4 bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">Featured</span>
             <?php endif; ?>
        </div>
        
        <div class="p-6 flex-grow flex flex-col">
            <h3 class="text-lg font-bold text-gray-800 mb-2 truncate" title="<?= htmlspecialchars($product['name']) ?>"><?= htmlspecialchars($product['name']) ?></h3>
            <p class="text-gray-600 text-sm mb-4 line-clamp-2 flex-grow"><?= htmlspecialchars($product['description']) ?></p>
            
            <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                <span class="text-2xl font-bold text-indigo-700">$<?= number_format($product['price'], 2) ?></span>
                
                <div class="flex space-x-2">
                     <a href="index.php?page=product&id=<?= $product['id'] ?>" class="text-gray-400 hover:text-indigo-600 transition p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </a>
                    <?php if (isset($_SESSION['user'])): ?>
                    <form action="index.php?action=add_to_cart" method="POST">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition font-semibold shadow-md flex items-center">
                            <span>Add</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </form>
                    <?php else: ?>
                    <a href="index.php?page=login" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition font-semibold shadow-md flex items-center">
                         <span>Add</span>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
