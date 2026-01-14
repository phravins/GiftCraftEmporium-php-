<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - GiftShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-800 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Admin Login</h2>
        <?php if (isset($_GET['error'])): ?>
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>
        <form action="index.php?action=admin_login" method="POST">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                <input type="text" name="username" required class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" required class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition">Login</button>
        </form>
    </div>
</body>
</html>
