<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - GiftShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-purple-600 to-blue-500 flex items-center justify-center min-h-screen font-sans">
    <div class="bg-white p-10 rounded-2xl shadow-2xl w-96 transform hover:scale-105 transition duration-300">
        <h2 class="text-3xl font-extrabold mb-6 text-center text-gray-800 tracking-tight">Welcome Back</h2>
        <?php if (isset($_GET['error'])): ?>
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded mb-4 text-sm font-medium">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['msg'])): ?>
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded mb-4 text-sm font-medium">
                <?= htmlspecialchars($_GET['msg']) ?>
            </div>
        <?php endif; ?>
        <form action="index.php?action=login" method="POST" class="space-y-5">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wide">Name</label>
                <input type="text" name="name" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wide">Phone Number</label>
                <input type="text" name="phone" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white p-3 rounded-lg hover:from-purple-700 hover:to-indigo-700 transition font-bold shadow-lg transform active:scale-95">Login</button>
        </form>
        <p class="mt-6 text-center text-sm text-gray-600">
            Don't have an account? <a href="index.php?page=register" class="text-indigo-600 hover:text-indigo-800 font-bold hover:underline">Sign up</a>
        </p>
    </div>
</body>
</html>
