<?php
include '../includes/init.php';

if (!isset($_SESSION['userid'])) {
    // If not logged in, redirect to index.php
    header("Location: login.php");
    exit(); // Stop further execution
}
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    // Destroy the session
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session

    // Redirect to the login page or any other page
    header("Location: login.php"); // Replace 'index.php' with your desired redirect page
    exit();
}?>
<!DOCTYPE html>
<html lang="en" class="transition-colors duration-300">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Farmer Dashboard</title>
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
        <p class="text-lg font-bold">🌱 Agri Invest</p>
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
          <p class="text-lg font-bold">🌱 Agri Invest</p>
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
        <h1 class="text-xl font-bold text-green-800 dark:text-green-300">Dashboard</h1>
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
            <a href="index.php" class="block px-4 py-2 text-red-500 hover:bg-gray-100 dark:hover:bg-gray-700">🚪 Logout</a>
          </div>
        </div>
      </div>
    </header>

    <!-- Quick stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
      <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow">
        <h2 class="text-gray-600 dark:text-gray-400">Wallet Balance</h2>
        <p class="text-2xl font-bold text-green-700 dark:text-green-400">₹ 12,500</p>
      </div>
      <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow">
        <h2 class="text-gray-600 dark:text-gray-400">Active Plans</h2>
        <p class="text-2xl font-bold text-green-700 dark:text-green-400">3</p>
      </div>
      <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow">
        <h2 class="text-gray-600 dark:text-gray-400">Pending Tasks</h2>
        <p class="text-2xl font-bold text-green-700 dark:text-green-400">2</p>
      </div>
    </div>

    <!-- Lucky Draw Banner -->
    <div class="mb-6 text-center">
      <img src="images/luckydraw.png" 
          class="w-full max-h-56 object-cover rounded-xl shadow-lg hover:scale-105 transition-transform mx-auto">
      <!-- Enter Lucky Draw Button -->
      <div class="mt-4">
        <a href="luckydraw.php" 
          class="inline-block bg-green-600 text-white px-6 py-2 rounded-lg shadow hover:bg-green-700 hover:scale-105 transition">
          🎁 Enter Lucky Draw
        </a>
      </div>
    </div>

    <!-- Quick Actions -->
    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-3">Quick Actions</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <a href="invite.php" class="bg-green-600 text-white p-6 rounded-xl flex flex-col items-center hover:scale-110 transition">🤝 Invite</a>
      <a href="deposit.php" class="bg-green-600 text-white p-6 rounded-xl flex flex-col items-center hover:scale-110 transition">⬆️ Deposit</a>
      <a href="withdraw.php" class="bg-green-600 text-white p-6 rounded-xl flex flex-col items-center hover:scale-110 transition">⬇️ Withdraw</a>
      <a href="bank.php" class="bg-green-600 text-white p-6 rounded-xl flex flex-col items-center hover:scale-110 transition">🏦 Bank</a>
      <a href="transactions.php" class="bg-green-600 text-white p-6 rounded-xl flex flex-col items-center hover:scale-110 transition">📑 My Bill</a>
      <a href="luckydraw.php" class="bg-green-600 text-white p-6 rounded-xl flex flex-col items-center hover:scale-110 transition">🎁 Lucky Draw</a>
    </div>
  </main>

  <!-- Bottom Nav (Mobile) -->
  <nav class="fixed bottom-0 left-0 right-0 bg-green-700 dark:bg-green-900 text-white flex justify-around py-3 md:hidden shadow-lg">
    <a href="dashboard.php">🏠</a>
    <a href="wallet.php">💰</a>
    <a href="plans.php">📋</a>
    <a href="transactions.php">📑</a>
    <a href="profile.php">👤</a>
  </nav>
</body>
</html>
