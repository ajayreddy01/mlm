<?php
include '../includes/init.php';
// If already logged in, redirect to dashboard
if (isset($_SESSION['userid'])) {
    header("Location: dashboard.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Collect form data
  $phone_number = checkinput($_POST['mobile']);
  $password = checkinput($_POST['password']);

  if (!empty($phone_number) && !empty($password)) {
    // Example: Log the collected data (you can process it as needed)
    $user->userLogin($phone_number, $password);

    // Example: Redirect to another page or process login
    // header('Location: dashboard.php');
    // exit();
  } else {
    echo "Please fill in all the required fields.";
  }
}
?>
<!DOCTYPE html>
<html lang="en" class="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Advanced Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = { darkMode: 'class' }
  </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 flex items-center justify-center min-h-screen p-4 transition-colors duration-300">

  <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-md p-8 space-y-6 transition-colors duration-300">
    <!-- Advanced Header with Logo -->
    <div class="flex justify-between items-center pb-3 border-b border-gray-200 dark:border-gray-700">
      <!-- Left: Logo + Title -->
      <div class="flex items-center space-x-3">
        <!-- Company Logo -->
        <img src="images/logo.jpeg" alt="Company Logo" class="w-10 h-10 rounded-full shadow-md">
        <!-- Title + Subtitle -->
        <div>
          <h1 class="text-2xl font-extrabold bg-gradient-to-r from-green-600 to-emerald-400 bg-clip-text text-transparent">
            Agri Invest
          </h1>
          <p class="text-xs text-gray-500 dark:text-gray-400">Secure login to your account</p>
        </div>
      </div>
      <!-- Right: Theme Toggle -->
      <button id="themeToggle" 
        class="relative w-12 h-12 flex items-center justify-center rounded-full backdrop-blur-md 
               bg-white/40 dark:bg-gray-700/40 border border-gray-300 dark:border-gray-600 
               shadow-md transition-transform hover:scale-110">
        <span id="themeIcon" class="text-xl">🌙</span>
      </button>
    </div>

    <!-- Form -->
    <form id="loginForm" class="space-y-5" action="" method="post">
      <!-- Mobile -->
      <div class="relative">
        <input type="text" id="mobile" name="mobile" required
          class="peer w-full px-3 pt-5 pb-2 rounded-lg border border-gray-300 dark:border-gray-600
                 text-gray-900 dark:text-white bg-transparent
                 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-green-400">
        <label for="mobile" class="absolute left-3 top-2 text-gray-500 text-sm transition-all 
               peer-placeholder-shown:top-4 peer-placeholder-shown:text-gray-400 peer-placeholder-shown:text-base 
               peer-focus:top-2 peer-focus:text-sm peer-focus:text-green-600">
          Mobile Number
        </label>
      </div>

      <!-- Password -->
      <div class="relative">
        <input type="password" id="password" name="password" required
          class="peer w-full px-3 pt-5 pb-2 rounded-lg border border-gray-300 dark:border-gray-600
                 text-gray-900 dark:text-white bg-transparent
                 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-green-400">
        <label for="password" class="absolute left-3 top-2 text-gray-500 text-sm transition-all 
               peer-placeholder-shown:top-4 peer-placeholder-shown:text-gray-400 peer-placeholder-shown:text-base 
               peer-focus:top-2 peer-focus:text-sm peer-focus:text-green-600">
          Password
        </label>
        <button type="submit" id="submit" name="submit" class="absolute right-3 top-3 text-gray-500 dark:text-gray-400">👁</button>
      </div>

      <!-- Remember Me -->
      <div class="flex items-center justify-between text-sm">
        <label class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
          <input type="checkbox" class="w-4 h-4 text-green-600 border-gray-300 rounded">
          Remember me
        </label>
        <a href="forgot-password.php" class="text-green-600 dark:text-green-400 hover:underline">Forgot password?</a>
      </div>

      <!-- Submit -->
      <button type="submit" id="loginBtn"
        class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition flex items-center justify-center gap-2">
        <span id="loginText">Login</span>
        <svg id="loadingIcon" class="animate-spin hidden h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
        </svg>
      </button>
    </form>

    <p class="text-center text-sm text-gray-600 dark:text-gray-400">
      Don’t have an account? 
      <a href="register.php" class="text-green-600 dark:text-green-400 hover:underline">Register</a>
    </p>
  </div>

  <!-- Toast -->
  <div id="toast" class="fixed bottom-5 right-5 hidden px-4 py-2 rounded-lg shadow-lg text-white text-sm transform transition-all duration-500"></div>

  <script>
    // Theme toggle
    const toggleBtn = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');
    const php = document.documentElement;
    toggleBtn.addEventListener('click', () => {
      php.classList.toggle('dark');
      themeIcon.textContent = php.classList.contains('dark') ? '☀️' : '🌙';
    });

    // Password toggle
    document.getElementById('togglePassword').addEventListener('click', () => {
      const passInput = document.getElementById('password');
      passInput.type = passInput.type === 'password' ? 'text' : 'password';
    });

    // Toast popup
    const toast = document.getElementById('toast');
    function showToast(message, type = 'success') {
      toast.textContent = message;
      toast.className = `fixed bottom-5 right-5 px-4 py-2 rounded-lg shadow-lg text-white text-sm transform transition-all duration-500 ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;
      toast.classList.remove('hidden');
      setTimeout(() => { toast.classList.add('translate-x-full'); }, 2500);
      setTimeout(() => { toast.classList.add('hidden'); toast.classList.remove('translate-x-full'); }, 3000);
    }

    // Form submit
    const loginForm = document.getElementById('loginForm');
    const loginBtn = document.getElementById('loginBtn');
    const loginText = document.getElementById('loginText');
    const loadingIcon = document.getElementById('loadingIcon');

    loginForm.addEventListener('submit', function(e) {
      e.preventDefault();
      loginText.textContent = "Processing...";
      loadingIcon.classList.remove('hidden');
      loginBtn.disabled = true;

      setTimeout(() => {
        loadingIcon.classList.add('hidden');
        loginText.textContent = "Login";
        loginBtn.disabled = false;

        const mobile = document.getElementById('mobile').value;
        const pass = document.getElementById('password').value;

        if (mobile === "9988776655" && pass === "1234") {
          showToast("✅ Login successful", "success");
          setTimeout(() => { window.location.href = "dashboard.php"; }, 1000);
        } else {
          showToast("❌ Invalid details", "error");
        }
      }, 1500);
    });
  </script>
</body>
</html>
