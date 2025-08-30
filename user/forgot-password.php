<?php
<?php
include '../includes/init.php';
// Logout logic
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    // Destroy session
    $_SESSION = [];
    session_destroy();

    // Redirect to login
    header("Location: index.php");
    exit();
}

// If already logged in, redirect to dashboard
if (isset($_SESSION['userid'])) {
    header("Location: dashboard.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en" class="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>tailwind.config = { darkMode: 'class' }</script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 flex items-center justify-center min-h-screen p-4 transition-colors duration-300">

  <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-md p-8 space-y-6 transition-colors duration-300">
    <!-- Header -->
    <div class="flex justify-between items-center">
      <h1 class="text-2xl font-bold text-green-700 dark:text-green-400">🔐 Forgot Password</h1>
      <button id="themeToggle" class="px-3 py-1 text-sm rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200">🌙</button>
    </div>

    <p class="text-sm text-gray-600 dark:text-gray-400">Enter your email or mobile number to reset your password.</p>

    <!-- Form -->
    <form id="forgotForm" class="space-y-5">
      <!-- Email/Mobile -->
      <div class="relative">
        <input type="text" id="identifier" required class="peer w-full px-3 pt-5 pb-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white bg-transparent placeholder-transparent focus:outline-none focus:ring-2 focus:ring-green-400">
        <label for="identifier" class="absolute left-3 top-2 text-gray-500 text-sm transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-gray-400 peer-placeholder-shown:text-base peer-focus:top-2 peer-focus:text-sm peer-focus:text-green-600">Email or Mobile</label>
      </div>

      <!-- Submit -->
      <button type="submit" id="forgotBtn" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition flex items-center justify-center gap-2">
        <span id="forgotText">Send Reset Link</span>
        <svg id="loadingIcon" class="animate-spin hidden h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>
      </button>
    </form>

    <p class="text-center text-sm text-gray-600 dark:text-gray-400">
      Remembered your password? <a href="index.php" class="text-green-600 dark:text-green-400 hover:underline">index</a>
    </p>
  </div>

  <!-- Toast -->
  <div id="toast" class="fixed bottom-5 right-5 hidden px-4 py-2 rounded-lg shadow-lg text-white text-sm transform transition-all duration-500"></div>

  <script>
    const toggleBtn = document.getElementById('themeToggle');
    const php = document.documentElement;
    toggleBtn.addEventListener('click', () => {
      php.classList.toggle('dark');
      toggleBtn.textContent = php.classList.contains('dark') ? '☀️' : '🌙';
    });

    const toast = document.getElementById('toast');
    function showToast(message, type = 'success') {
      toast.textContent = message;
      toast.className = `fixed bottom-5 right-5 px-4 py-2 rounded-lg shadow-lg text-white text-sm transition-all duration-500 ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;
      toast.classList.remove('hidden');
      setTimeout(() => toast.classList.add('hidden'), 3000);
    }

    const forgotForm = document.getElementById('forgotForm');
    forgotForm.addEventListener('submit', function(e) {
      e.preventDefault();
      showToast("✅ Reset link sent successfully", "success");
    });
  </script>
</body>
</html>
