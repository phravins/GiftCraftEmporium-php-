<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gift Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-gray-50 flex flex-col min-h-screen font-sans">
    <nav class="bg-gradient-to-r from-purple-600 to-indigo-600 shadow-lg">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="index.php" class="text-2xl font-bold text-white tracking-wide hover:text-gray-100 transition">GiftShop</a>
            <div class="flex items-center space-x-6">
                <a href="index.php" class="text-white hover:text-gray-200 transition font-medium">Home</a>
                
                <?php if ($user): ?>
                    <span class="text-indigo-100">Hi, <?= htmlspecialchars($user['name']) ?></span>
                    <a href="index.php?page=cart" class="text-white hover:text-gray-200 transition relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <?php if ($cart_count > 0): ?>
                            <span class="absolute -top-2 -right-2 bg-pink-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold">
                                <?= $cart_count ?>
                            </span>
                        <?php endif; ?>
                    </a>
                    <a href="index.php?page=orders" class="text-white hover:text-gray-200 transition font-medium">Orders</a>
                    <a href="index.php?action=logout" class="bg-white text-indigo-600 px-4 py-2 rounded-full font-bold hover:bg-gray-100 transition shadow-sm">Logout</a>
                <?php else: ?>
                    <a href="index.php?page=login" class="bg-white text-indigo-600 px-6 py-2 rounded-full font-bold hover:bg-gray-100 transition shadow-md">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <main class="container mx-auto px-6 py-8 flex-grow">
