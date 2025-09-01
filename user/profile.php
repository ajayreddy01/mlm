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
$walletdata = $wallet->getWalletBalance($_SESSION['userid']);
$userdata = $admin->selectDataWithConditions('users', null, ['userid' => $_SESSION['userid']]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profile - Agri Invest</title>
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
        <p class="text-sm text-green-200">Welcome, <?php echo $userdata[0]['name']?> 👨‍🌾</p>
      </div>
    </div>
    <nav class="flex flex-col space-y-3 mt-6 overflow-y-auto">
      <a href="dashboard.php" class="flex items-center gap-2 hover:bg-green-600 p-2 rounded">🏠 Dashboard</a>
      <a href="wallet.php" class="flex items-center gap-2 hover:bg-green-600 p-2 rounded">💰 Wallet</a>
      <a href="plans.php" class="flex items-center gap-2 hover:bg-green-600 p-2 rounded">📋 Plans</a>
      <a href="luckydraw.php" class="flex items-center gap-2 hover:bg-green-600 p-2 rounded">🎁 Lucky Draw</a>
      <a href="tasks.php" class="flex items-center gap-2 hover:bg-green-600 p-2 rounded">✅ Tasks</a>
      
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
          <p class="text-sm text-green-200">Welcome, <?php echo $userdata[0]['name']?> 👨‍🌾</p>
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
        <h1 class="text-xl font-bold text-green-800 dark:text-green-300">Profile</h1>
      </div>
      <div class="flex items-center gap-4">
        <button onclick="toggleTheme()" class="bg-gray-200 dark:bg-yellow-400 px-3 py-1 rounded-lg">🌗</button>
       
        <!-- Profile -->
        <div class="relative">
          <img id="profileBtn" onclick="toggleProfileMenu()" 
               src="images/profile.jpg" 
               class="w-10 h-10 rounded-full border shadow cursor-pointer">
          <div id="profileMenu" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden z-50">
             <!-- <a href="profile.php" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">👤 Profile</a> -->
            <a href="whatsapp.php" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">📱 WhatsApp Group</a>
            <a href="settings.php" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">⚙️ Settings</a>
            <a href="dashboard.php?logout=true" class="block px-4 py-2 text-red-500 hover:bg-gray-100 dark:hover:bg-gray-700">🚪 Logout</a>
          </div>
        </div>
      </div>
    </header>

    <!-- Profile Section -->
    <main class="p-6 flex-1">

      <!-- Profile Card -->
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 max-w-2xl mx-auto">
        
        <div class="flex flex-col items-center relative">
          <label class="absolute bottom-12 right-[40%] bg-green-600 text-white px-2 py-1 rounded-full text-xs cursor-pointer hover:bg-green-700">
            ✏️
            <input type="file" class="hidden" />
          </label>
          <img src="images/profile.jpg" alt="Profile" class="w-24 h-24 rounded-full border-4 border-green-600 shadow">
         
          <h2 class="text-xl font-bold text-green-700 dark:text-green-400 mt-3"><?php echo $userdata[0]['name']?> Kumar</h2>
          <p class="text-gray-500 dark:text-gray-400 text-sm">Village: Rampur</p>
        </div>

        <!-- Balance Stats -->
        <div class="grid grid-cols-2 gap-4 mt-6">
          <div class="bg-green-100 dark:bg-green-900 p-4 rounded-xl text-center">
            <h3 class="text-gray-600 dark:text-gray-300 text-sm">Wallet Balance</h3>
            <p class="text-lg font-bold text-green-700 dark:text-green-400">₹ 12,500</p>
          </div>
          <div class="bg-yellow-100 dark:bg-yellow-900 p-4 rounded-xl text-center">
            <h3 class="text-gray-600 dark:text-gray-300 text-sm">Bonus Balance</h3>
            <p class="text-lg font-bold text-yellow-700 dark:text-yellow-400">₹ 500</p>
          </div>
        </div>

        <!-- Profile Form -->
        <form class="mt-6 space-y-4">
          <div>
            <label class="block text-gray-600 dark:text-gray-300">Full Name</label>
            <input type="text" value="<?php echo $userdata[0]['name']?> Kumar" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-600 dark:bg-gray-700 dark:text-white">
          </div>
          <div>
            <label class="block text-gray-600 dark:text-gray-300">Mobile Number</label>
            <input type="text" value="9876543210" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-600 dark:bg-gray-700 dark:text-white">
          </div>
          <div>
            <label class="block text-gray-600 dark:text-gray-300">Village</label>
            <input type="text" value="Rampur" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-600 dark:bg-gray-700 dark:text-white">
          </div>
          <div>
            <label class="block text-gray-600 dark:text-gray-300">Crops Grown</label>
            <input type="text" value="Wheat, Rice" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-600 dark:bg-gray-700 dark:text-white">
          </div>
          <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">Save Changes</button>
        </form>
      </div>
    </main>
  </div>

  <!-- Bottom Navigation (mobile) -->
  <nav class="fixed bottom-0 left-0 right-0 bg-green-700 dark:bg-green-900 text-white flex justify-around py-3 md:hidden shadow-lg">
    <a href="dashboard.php" class="hover:scale-125 transform transition">🏠</a>
    <a href="wallet.php" class="hover:scale-125 transform transition">💰</a>
    <a href="plans.php" class="hover:scale-125 transform transition">📋</a>
    <a href="transactions.php" class="hover:scale-125 transform transition">📑</a>
    <a href="profile.php" class="font-bold hover:scale-125 transform transition">👤</a>
  </nav>
</body>
</html>
