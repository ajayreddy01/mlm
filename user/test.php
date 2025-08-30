<?php
include '../includes/init.php';

if (!isset($_SESSION['userid'])) {
    // If not logged in, redirect to index.php
    header("Location: index.php");
    exit(); // Stop further execution
}
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    // Destroy the session
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session

    // Redirect to the login page or any other page
    header("Location: index.php"); // Replace 'index.php' with your desired redirect page
    exit();
}?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dark Mode Test</title>

  <!-- ✅ Enable dark mode via Tailwind config -->
  <script>
    tailwind.config = {
      darkMode: 'class'
    }
  </script>

  <!-- ✅ Load Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 flex items-center justify-center min-h-screen transition-colors">

  <div class="p-6 rounded-2xl shadow bg-white dark:bg-gray-800 text-center space-y-4 transition-colors">
    <h1 class="text-xl font-bold text-green-700 dark:text-green-400">🌱 Agri Invest</h1>
    <p class="text-gray-600 dark:text-gray-300">Toggle between Light & Dark Theme</p>
    <button onclick="toggleTheme()" 
            class="bg-gray-200 dark:bg-yellow-400 px-3 py-2 rounded-lg transition-colors">
      🌗 Toggle Theme
    </button>
  </div>

  <script>
    function toggleTheme() {
      document.documentElement.classList.toggle("dark");
      localStorage.setItem("theme",
        document.documentElement.classList.contains("dark") ? "dark" : "light"
      );
    }

    // ✅ Apply saved theme on page load
    if (localStorage.getItem("theme") === "dark") {
      document.documentElement.classList.add("dark");
    }
  </script>
</body>
</html>
