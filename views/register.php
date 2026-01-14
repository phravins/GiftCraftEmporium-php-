<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - GiftShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-green-400 to-teal-500 flex items-center justify-center min-h-screen font-sans">
    <div class="bg-white p-10 rounded-2xl shadow-2xl w-96 transform hover:scale-105 transition duration-300">
        <h2 class="text-3xl font-extrabold mb-6 text-center text-gray-800 tracking-tight">Create Account</h2>
        <?php if (isset($_GET['error'])): ?>
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded mb-4 text-sm font-medium">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>
        <form action="index.php?action=register" method="POST" class="space-y-5">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wide">Name</label>
                <input type="text" name="name" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wide">Phone Number</label>
                <input type="text" name="phone" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wide">Address</label>
                <textarea name="address" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition h-24"></textarea>
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-teal-600 text-white p-3 rounded-lg hover:from-green-600 hover:to-teal-700 transition font-bold shadow-lg transform active:scale-95">Register</button>
        </form>
        <p class="mt-6 text-center text-sm text-gray-600">
            Already have an account? <a href="index.php?page=login" class="text-teal-600 hover:text-teal-800 font-bold hover:underline">Login here</a>
        </p>
    </div>
</body>
</html>
