<?php
$id = $_GET['id'] ?? 0;
$db = Database::getConnection();

$stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    echo "Product not found.";
    exit;
}

// Get Reviews
$reviews_stmt = $db->prepare("SELECT r.*, u.name FROM reviews r JOIN users u ON r.user_id = u.id WHERE product_id = ? ORDER BY r.created_at DESC");
$reviews_stmt->execute([$id]);
$reviews = $reviews_stmt->fetchAll();
?>

<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <div class="md:flex">
        <div class="md:w-1/2">
            <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full h-full object-cover">
        </div>
        <div class="md:w-1/2 p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-4"><?= htmlspecialchars($product['name']) ?></h1>
            <p class="text-gray-600 mb-6"><?= htmlspecialchars($product['description']) ?></p>
            <div class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600 mb-6">$<?= number_format($product['price'], 2) ?></div>
            
            <?php if (isset($_SESSION['user'])): ?>
            <form action="index.php?action=add_to_cart" method="POST" class="flex items-center space-x-4 mb-8">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <div class="flex items-center border-2 border-purple-100 rounded-lg overflow-hidden">
                    <button type="button" onclick="this.nextElementSibling.stepDown()" class="px-4 py-2 bg-purple-50 hover:bg-purple-100 text-purple-700 font-bold transition">-</button>
                    <input type="number" name="quantity" value="1" min="1" class="w-16 text-center p-2 border-x-2 border-purple-100 focus:outline-none font-semibold text-gray-700">
                    <button type="button" onclick="this.previousElementSibling.stepUp()" class="px-4 py-2 bg-purple-50 hover:bg-purple-100 text-purple-700 font-bold transition">+</button>
                </div>
                <button type="submit" class="flex-1 bg-gradient-to-r from-purple-600 to-pink-500 text-white px-6 py-3 rounded-lg hover:from-purple-700 hover:to-pink-600 font-bold shadow-lg transform active:scale-95 transition-all flex items-center justify-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span>Add to Cart</span>
                </button>
            </form>
            <?php else: ?>
                <div class="bg-yellow-50 p-4 rounded text-yellow-800 mb-8">
                    Please <a href="index.php?page=login" class="underline font-bold">login</a> to purchase.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Reviews Section -->
<div class="mt-8 bg-white rounded-lg shadow-lg p-8">
    <h2 class="text-2xl font-bold mb-6">Customer Reviews</h2>
    
    <?php if (isset($_SESSION['user'])): ?>
    <form action="index.php?action=submit_review" method="POST" class="mb-8 p-4 bg-gray-50 rounded">
        <h3 class="font-bold mb-2">Write a Review</h3>
        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
        <div class="mb-2">
            <label class="block text-sm">Rating:</label>
            <select name="rating" class="border rounded p-1">
                <option value="5">5 - Excellent</option>
                <option value="4">4 - Good</option>
                <option value="3">3 - Average</option>
                <option value="2">2 - Poor</option>
                <option value="1">1 - Terrible</option>
            </select>
        </div>
        <div class="mb-2">
            <textarea name="comment" placeholder="Your review..." required class="w-full border rounded p-2"></textarea>
        </div>
        <button type="submit" class="bg-gray-800 text-white px-4 py-1 rounded text-sm">Submit Review</button>
    </form>
    <?php endif; ?>

    <div class="space-y-4">
        <?php foreach ($reviews as $review): ?>
        <div class="border-b pb-4 last:border-0">
            <div class="flex items-center justify-between mb-1">
                <span class="font-bold"><?= htmlspecialchars($review['name']) ?></span>
                <span class="text-yellow-500 font-bold"><?= str_repeat('★', $review['rating']) ?></span>
            </div>
            <p class="text-gray-600"><?= htmlspecialchars($review['comment']) ?></p>
            <span class="text-xs text-gray-400"><?= date('M d, Y', strtotime($review['created_at'])) ?></span>
        </div>
        <?php endforeach; ?>
        <?php if (empty($reviews)) echo "<p class='text-gray-500'>No reviews yet.</p>"; ?>
    </div>
</div>
