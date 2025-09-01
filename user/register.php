<?php
include '../includes/init.php';

// Logout logic
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    // Destroy session
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
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

// Registration handling
if (isset($_POST['submit'])) {
    $name       = checkinput($_POST['name']);
    $mobile     = checkinput($_POST['phone_number']);
    $email      = checkinput($_POST['email']);
    $password   = checkinput($_POST['password']);
    $confirmPwd = checkinput($_POST['confirmPassword']);
    $inviteCode = checkinput($_GET['invite_code'] ?? '');

    // Extra check on server side
    if ($password !== $confirmPwd) {
        $_SESSION['error'] = "Passwords do not match";
        header("Location: index.php");
        exit();
    }

    if (!empty($inviteCode) && $user->check_invite_code($inviteCode) === true) {
        $user->userSignup($name, $mobile, $password, $inviteCode,$email);
    } else {
        $user->userSignup($name, $mobile, $password, null,$email);
    }

    // After signup, redirect to login
    header("Location: " . BASE_URL . "user/index.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en" class="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>tailwind.config = { darkMode: 'class' }</script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 flex items-center justify-center min-h-screen p-4 transition-colors duration-300">

  <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-md p-8 space-y-6 transition-colors duration-300">
    <!-- Advanced Register Header with Logo -->
<div class="flex justify-between items-center pb-3 border-b border-gray-200 dark:border-gray-700">

  <!-- Left: Logo + Title -->
  <div class="flex items-center space-x-3">
    <!-- Company Logo -->
    <img src="images/logo.jpeg" alt="Company Logo" class="w-10 h-10 rounded-full shadow-md">

    <!-- Title + Subtitle -->
    <div>
      <h1 class="text-2xl font-extrabold bg-gradient-to-r from-green-600 to-emerald-400 bg-clip-text text-transparent">
        📝 Register
      </h1>
      <p class="text-xs text-gray-500 dark:text-gray-400">Create your new account</p>
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
    <form id="registerForm" class="space-y-5" action="" method="post">
      <!-- Name -->
      <div class="relative">
        <input type="text" id="name" name="name" required class="peer w-full px-3 pt-5 pb-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white bg-transparent placeholder-transparent focus:outline-none focus:ring-2 focus:ring-green-400">
        <label for="name" class="absolute left-3 top-2 text-gray-500 text-sm transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-gray-400 peer-placeholder-shown:text-base peer-focus:top-2 peer-focus:text-sm peer-focus:text-green-600">Full Name</label>
      </div>

      <!-- Mobile -->
      <div class="relative">
        <input type="text" id="phone_number" name="phone_number" required class="peer w-full px-3 pt-5 pb-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white bg-transparent placeholder-transparent focus:outline-none focus:ring-2 focus:ring-green-400">
        <label for="mobile" class="absolute left-3 top-2 text-gray-500 text-sm transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-gray-400 peer-placeholder-shown:text-base peer-focus:top-2 peer-focus:text-sm peer-focus:text-green-600">Mobile Number</label>
      </div>

      <!-- Email -->
      <div class="relative">
        <input type="email" id="email" name="email" required class="peer w-full px-3 pt-5 pb-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white bg-transparent placeholder-transparent focus:outline-none focus:ring-2 focus:ring-green-400">
        <label for="email" class="absolute left-3 top-2 text-gray-500 text-sm transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-gray-400 peer-placeholder-shown:text-base peer-focus:top-2 peer-focus:text-sm peer-focus:text-green-600">Email</label>
      </div>

      <!-- Password -->
      <div class="relative">
        <input type="password" name="password" id="password" required class="peer w-full px-3 pt-5 pb-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white bg-transparent placeholder-transparent focus:outline-none focus:ring-2 focus:ring-green-400">
        <label for="password" class="absolute left-3 top-2 text-gray-500 text-sm transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-gray-400 peer-placeholder-shown:text-base peer-focus:top-2 peer-focus:text-sm peer-focus:text-green-600">Password</label>
        <button type="button" id="togglePassword" class="absolute right-3 top-3 text-gray-500 dark:text-gray-400">👁</button>
      </div>

      <!-- Confirm Password -->
      <div class="relative">
        <input type="password" id="confirmPassword" name="confirmPassword" required class="peer w-full px-3 pt-5 pb-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white bg-transparent placeholder-transparent focus:outline-none focus:ring-2 focus:ring-green-400">
        <label for="confirmPassword" class="absolute left-3 top-2 text-gray-500 text-sm transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-gray-400 peer-placeholder-shown:text-base peer-focus:top-2 peer-focus:text-sm peer-focus:text-green-600">Confirm Password</label>
      </div>

      <!-- Submit -->
      <button type="submit" id="submit" name="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition flex items-center justify-center gap-2">
        <span id="registerText">Register</span>
        <svg id="loadingIcon" class="animate-spin hidden h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>
      </button>
    </form>

    <p class="text-center text-sm text-gray-600 dark:text-gray-400">
      Already have an account? <a href="index.php" class="text-green-600 dark:text-green-400 hover:underline">Login</a>
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

    document.getElementById('togglePassword').addEventListener('click', () => {
      const passInput = document.getElementById('password');
      passInput.type = passInput.type === 'password' ? 'text' : 'password';
    });

    const toast = document.getElementById('toast');
    function showToast(message, type = 'success') {
      toast.textContent = message;
      toast.className = `fixed bottom-5 right-5 px-4 py-2 rounded-lg shadow-lg text-white text-sm transition-all duration-500 ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;
      toast.classList.remove('hidden');
      setTimeout(() => toast.classList.add('hidden'), 3000);
    }
  </script>
</body>
</html>
