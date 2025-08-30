<!DOCTYPE html>
<html lang="en" class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password - FarmerApp</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen">

  <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 space-y-6">
    
    <!-- Header -->
    <div class="text-center">
      <img src="images/profile.jpg" class="w-16 h-16 rounded-full border-2 border-green-600 shadow mx-auto">
      <h1 class="text-2xl font-bold text-green-700 dark:text-green-400 mt-2">🌱 FarmerApp</h1>
      <p class="text-sm text-gray-500 dark:text-gray-400">Set a new password</p>
    </div>
<!-- Success Alert -->
<div id="resetSuccess" class="hidden p-3 rounded-lg bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300 flex items-center justify-between">
  <span>🔒 Password reset successful! Please login again.</span>
  <button onclick="this.parentElement.style.display='none'" class="font-bold">×</button>
</div>

    <!-- Form -->
    <form action="login.php" method="POST" class="space-y-4">
      <div>
        <label class="block text-sm font-medium mb-1">New Password</label>
        <input type="password" name="new_password" required
          class="w-full px-4 py-2 border rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 focus:ring-2 focus:ring-green-500">
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Confirm Password</label>
        <input type="password" name="confirm_password" required
          class="w-full px-4 py-2 border rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 focus:ring-2 focus:ring-green-500">
      </div>
      <button type="submit"
        class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-xl font-semibold transition">
        Reset Password
      </button>
      
    </form>

    <!-- Links -->
    <div class="text-center text-sm">
      <a href="login.php" class="text-green-600 dark:text-green-400 hover:underline">⬅ Back to Login</a>
    </div>

   
  </div>

  <!-- Theme Script -->
  <script>
    function toggleTheme() {
      document.documentElement.classList.toggle("dark");
      if (document.documentElement.classList.contains("dark")) {
        localStorage.setItem("theme", "dark");
      } else {
        localStorage.setItem("theme", "light");
      }
    }
    if (localStorage.getItem("theme") === "dark") {
      document.documentElement.classList.add("dark");
    }
    document.getElementById("resetSuccess").classList.remove("hidden");
    setTimeout(() => window.location.href = "login.php", 2000);

  </script>
  
</body>
</html>
