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
if (!isset($_SESSION['userid'])) {
    header("Location: index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en" > <!-- Add 'dark' here if you want default dark -->
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tasks - FarmerApp</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = { darkMode: 'class' }

    function toggleTheme() {
      document.documentElement.classList.toggle("dark");
      localStorage.setItem("theme",
        document.documentElement.classList.contains("dark") ? "dark" : "light"
      );
    }

    if (localStorage.getItem("theme") === "dark") {
      document.documentElement.classList.add("dark");
    }

    function toggleProfileMenu() {
      document.getElementById("profileMenu").classList.toggle("hidden");
      document.getElementById("notifMenu").classList.add("hidden");
    }

    function toggleNotifMenu() {
      document.getElementById("notifMenu").classList.toggle("hidden");
      document.getElementById("profileMenu").classList.add("hidden");
    }

    function toggleSidebar() {
      document.getElementById("mobileSidebar").classList.toggle("hidden");
    }

    window.addEventListener("click", function(e) {
      const profileMenu = document.getElementById("profileMenu");
      const notifMenu = document.getElementById("notifMenu");
      const profileBtn = document.getElementById("profileBtn");
      const notifBtn = document.getElementById("notifBtn");
      const sidebar = document.getElementById("mobileSidebar");
      const sidebarBtn = document.getElementById("sidebarBtn");

      if (profileMenu && !profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
        profileMenu.classList.add("hidden");
      }
      if (notifMenu && !notifBtn.contains(e.target) && !notifMenu.contains(e.target)) {
        notifMenu.classList.add("hidden");
      }
      if (sidebar && !sidebar.contains(e.target) && !sidebarBtn.contains(e.target)) {
        sidebar.classList.add("hidden");
      }
    });
  </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen flex text-gray-900 dark:text-gray-100">

  <!-- Sidebar (Desktop - Fixed) -->
  <aside class="hidden md:flex md:flex-col fixed top-0 left-0 w-64 h-screen bg-green-700 dark:bg-green-900 text-white p-6 space-y-6">
    <div class="flex items-center gap-3">
      <img src="images/profile.jpg" class="w-12 h-12 rounded-full border-2 border-white shadow">
      <div>
        <p class="text-lg font-bold">🌱 FarmerApp</p>
        <p class="text-sm text-green-200">Welcome, Ramesh 👨‍🌾</p>
      </div>
    </div>
    <nav class="flex flex-col space-y-3 mt-6 overflow-y-auto">
      <a href="dashboard.php" class="flex items-center gap-2 hover:bg-green-600 p-2 rounded">🏠 Dashboard</a>
      <a href="wallet.php" class="flex items-center gap-2 hover:bg-green-600 p-2 rounded">💰 Wallet</a>
      <a href="plans.php" class="flex items-center gap-2 hover:bg-green-600 p-2 rounded">📋 Plans</a>
      <a href="luckydraw.php" class="flex items-center gap-2 hover:bg-green-600 p-2 rounded">🎁 Lucky Draw</a>
      <a href="tasks.php" class="flex items-center gap-2 hover:bg-green-600 p-2 rounded">✅ Tasks</a>
      <a href="transactions.php" class="flex items-center gap-2 hover:bg-green-600 p-2 rounded">📑 My Bill</a>
      <a href="bank.php" class="flex items-center gap-2 hover:bg-green-600 p-2 rounded">🏦 Bank Account</a>
      <a href="invite.php" class="flex items-center gap-2 hover:bg-green-600 p-2 rounded">🤝 Invite</a>
      <a href="deposit.php" class="flex items-center gap-2 hover:bg-green-600 p-2 rounded">⬆️ Deposit</a>
      <a href="withdraw.php" class="flex items-center gap-2 hover:bg-green-600 p-2 rounded">⬇️ Withdraw</a>
    </nav>
  </aside>

  <!-- Mobile Sidebar (Overlay) -->
  <div id="mobileSidebar" class="hidden fixed top-0 left-0 w-64 h-full bg-green-700 dark:bg-green-900 text-white p-6 space-y-6 z-50">
    <div class="flex items-center justify-between">
      <div class="flex items-center gap-3">
        <img src="images/profile.jpg" class="w-12 h-12 rounded-full border-2 border-white shadow">
        <div>
          <p class="text-lg font-bold">🌱 FarmerApp</p>
          <p class="text-sm text-green-200">Welcome, Ramesh 👨‍🌾</p>
        </div>
      </div>
      <button onclick="toggleSidebar()">❌</button>
    </div>
    <nav class="flex flex-col space-y-3 mt-6">
      <a href="dashboard.php" class="hover:bg-green-600 p-2 rounded">🏠 Dashboard</a>
      <a href="wallet.php" class="hover:bg-green-600 p-2 rounded">💰 Wallet</a>
      <a href="plans.php" class="hover:bg-green-600 p-2 rounded">📋 Plans</a>
      <a href="luckydraw.php" class="hover:bg-green-600 p-2 rounded">🎁 Lucky Draw</a>
      <a href="tasks.php" class="hover:bg-green-600 p-2 rounded">✅ Tasks</a>
      <a href="transactions.php" class="hover:bg-green-600 p-2 rounded">📑 My Bill</a>
      <a href="bank.php" class="hover:bg-green-600 p-2 rounded">🏦 Bank</a>
      <a href="invite.php" class="hover:bg-green-600 p-2 rounded">🤝 Invite</a>
      <a href="deposit.php" class="hover:bg-green-600 p-2 rounded">⬆️ Deposit</a>
      <a href="withdraw.php" class="hover:bg-green-600 p-2 rounded">⬇️ Withdraw</a>
    </nav>
  </div>

  <!-- Main -->
  <main class="flex-1 md:ml-64 p-6"> <!-- Added md:ml-64 -->
    <!-- Navbar -->
    <header class="flex items-center justify-between mb-6 relative">
      <div class="flex items-center gap-4">
        <!-- Mobile Sidebar Button -->
        <button id="sidebarBtn" onclick="toggleSidebar()" class="md:hidden text-2xl">☰</button>
        <h1 class="text-xl font-bold text-green-800 dark:text-green-300">Tasks</h1>
      </div>
      <div class="flex items-center gap-4">
        <button onclick="toggleTheme()" class="bg-gray-200 dark:bg-yellow-400 px-3 py-1 rounded-lg">🌗</button>
        
        <!-- Notifications -->
        <div class="relative">
          <button id="notifBtn" onclick="toggleNotifMenu()" class="relative cursor-pointer">
            🔔
            <span class="absolute -top-1 -right-1 bg-red-500 text-xs text-white px-1 rounded-full">3</span>
          </button>
          <div id="notifMenu" class="hidden absolute right-0 mt-2 w-72 bg-white dark:bg-gray-800 rounded-xl shadow-lg z-50">
            <div class="p-3 border-b dark:border-gray-700 font-semibold">Notifications</div>
            <div class="max-h-60 overflow-y-auto">
              <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">💰 You received ₹500 in Wallet</a>
              <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">✅ Task "Water wheat field" is pending</a>
              <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">🎁 Lucky Draw #124124 starts today</a>
              <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">⚠️ Update your bank account details</a>
            </div>
            <div class="p-2 text-center border-t dark:border-gray-700">
              <a href="notifications.php" class="text-green-600 dark:text-green-400 text-sm font-medium">View All</a>
            </div>
          </div>
        </div>

        <!-- Profile -->
        <div class="relative">
          <img id="profileBtn" onclick="toggleProfileMenu()" 
               src="images/profile.jpg" 
               class="w-10 h-10 rounded-full border shadow cursor-pointer">
          <div id="profileMenu" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden z-50">
            <a href="profile.php" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">👤 Profile</a>
            <a href="whatsapp.php" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">📱 WhatsApp Group</a>
            <a href="settings.php" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">⚙️ Settings</a>
            <a href="dashboard.php?logout=true" class="block px-4 py-2 text-red-500 hover:bg-gray-100 dark:hover:bg-gray-700">🚪 Logout</a>
          </div>
        </div>
      </div>
    </header>


    <!-- Rewards Section -->
    <section class="p-6">
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
        <h2 class="text-lg font-semibold text-green-700 dark:text-green-300 mb-2">🎁 Invite Rewards</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
          Invite valid members every day and you will be automatically rewarded.
        </p>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
          <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl shadow">
            <p class="text-gray-500 dark:text-gray-300 text-sm">Invited</p>
            <p class="text-xl font-bold text-green-700 dark:text-green-400">0</p>
          </div>
          <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl shadow">
            <p class="text-gray-500 dark:text-gray-300 text-sm">Per Reward</p>
            <p class="text-xl font-bold text-blue-600">₹100</p>
          </div>
          <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl shadow">
            <p class="text-gray-500 dark:text-gray-300 text-sm">Progress</p>
            <p class="text-xl font-bold text-yellow-600">0 / Edited</p>
          </div>
          <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl shadow">
            <p class="text-gray-500 dark:text-gray-300 text-sm">Total Reward</p>
            <p class="text-xl font-bold text-purple-600">₹0</p>
          </div>
        </div>
        <div class="mt-4 flex justify-center">
          <a href="invite.php" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg shadow-md">Invite People</a>
        </div>
      </div>
    </section>

    <!-- Task List -->
    <section class="p-6 flex-1">
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
        <h2 class="text-lg font-semibold text-green-700 dark:text-green-300 mb-4">Today’s Tasks</h2>

        <ul class="space-y-4">
          <li class="flex items-center justify-between bg-gray-50 dark:bg-gray-700 px-4 py-3 rounded-xl shadow-sm">
            <label class="flex items-center space-x-3">
              <input type="checkbox" class="w-5 h-5 text-green-600 rounded">
              <span class="text-gray-700 dark:text-gray-200">Water wheat field</span>
            </label>
            <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded">Pending</span>
          </li>
          <li class="flex items-center justify-between bg-gray-50 dark:bg-gray-700 px-4 py-3 rounded-xl shadow-sm">
            <label class="flex items-center space-x-3">
              <input type="checkbox" class="w-5 h-5 text-green-600 rounded" checked>
              <span class="line-through text-gray-400">Check irrigation pump</span>
            </label>
            <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded">Done</span>
          </li>
          <li class="flex items-center justify-between bg-gray-50 dark:bg-gray-700 px-4 py-3 rounded-xl shadow-sm">
            <label class="flex items-center space-x-3">
              <input type="checkbox" class="w-5 h-5 text-green-600 rounded">
              <span class="text-gray-700 dark:text-gray-200">Buy fertilizer from store</span>
            </label>
            <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded">Pending</span>
          </li>
          <li class="flex items-center justify-between bg-gray-50 dark:bg-gray-700 px-4 py-3 rounded-xl shadow-sm">
            <label class="flex items-center space-x-3">
              <input type="checkbox" class="w-5 h-5 text-green-600 rounded">
              <span class="text-gray-700 dark:text-gray-200">Feed livestock</span>
            </label>
            <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded">Pending</span>
          </li>
        </ul>
      </div>
    </section>
  </main>

  <!-- Bottom Navigation (Mobile only) -->
  <nav class="fixed bottom-0 left-0 right-0 bg-green-700 text-white flex justify-around py-3 md:hidden">
    <a href="dashboard.php">🏠</a>
    <a href="wallet.php">💰</a>
    <a href="plans.php">📋</a>
    <a href="transactions.php">📑</a>
    <a href="profile.php">👤</a>
  </nav>

  
</body>
</html>
