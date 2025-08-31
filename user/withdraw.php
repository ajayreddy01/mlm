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
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Withdraw - Agri Invest</title>
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
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen flex">

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
      
      <a href="bank.php" class="flex items-center gap-2 hover:bg-green-600 p-2 rounded">🏦 Bank Account</a>
      <a href="invite.php" class="flex items-center gap-2 hover:bg-green-600 p-2 rounded">🤝 Invite</a>
      <a href="deposit.php" class="flex items-center gap-2 hover:bg-green-600 p-2 rounded">⬆️ Deposit</a>
      <a href="withdraw.php" class="flex items-center gap-2 hover:bg-green-600 p-2 rounded">⬇️ Withdraw</a>
    </nav>
  </aside>

  <!-- Mobile Sidebar (Overlay) -->
  <div id="mobileSidebar" class="hidden fixed top-0 left-0 w-64 h-full bg-green-700 dark:bg-green-900 text-white p-6 space-y-6 z-50 md:hidden">
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
  <main class="flex-1 md:ml-64 p-4 sm:p-6">
    <!-- Navbar -->
    <header class="flex items-center justify-between mb-6 relative">
      <div class="flex items-center gap-4">
        <!-- Mobile Sidebar Button -->
        <button id="sidebarBtn" onclick="toggleSidebar()" class="md:hidden text-2xl">☰</button>
        <h1 class="text-xl font-bold text-green-800 dark:text-green-300">Withdraw</h1>
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

    <!-- Balances -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 auto-rows-fr">
        <!-- Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 flex flex-col justify-between min-h-[140px]">
          <h2 class="text-sm text-gray-500 dark:text-gray-400">Balance</h2>
          <p class="text-3xl font-extrabold tabular-nums text-green-700 dark:text-green-400">₹<?php echo $walletdata->deposit+$walletdata->withdraw+$walletdata->bonus;?></p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 flex flex-col justify-between min-h-[140px]">
          <h2 class="text-sm text-gray-500 dark:text-gray-400">Deposit Balance</h2>
          <p class="text-3xl font-extrabold tabular-nums text-green-700 dark:text-green-400">₹ <?php echo $walletdata->deposit;?></p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 flex flex-col justify-between min-h-[140px]">
          <h2 class="text-sm text-gray-500 dark:text-gray-400">Withdraw Balance</h2>
          <p class="text-3xl font-extrabold tabular-nums text-green-700 dark:text-green-400">₹ <?php echo $walletdata->withdraw;?></p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 flex flex-col justify-between min-h-[140px]">
          <h2 class="text-sm text-gray-500 dark:text-gray-400">Bonus Balance</h2>
          <p class="text-3xl font-extrabold tabular-nums text-green-700 dark:text-green-400">₹ <?php echo $walletdata->bonus;?></p>
        </div>
      </section>


    <!-- Notice -->
    <section class="bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-300 p-4 rounded-lg mb-6 shadow">
      <h2 class="font-semibold mb-2">⚠️ Notice</h2>
      <p>All Withdraws are Settled Within <b>24 Hours</b> After the Request is Made.</p>
      <p>Flat Rate of <b>10% Deduction</b> is made in all Withdraws.</p>
      <p>The Minimum Withdraw is <b>INR 550</b>.</p>
    </section>

   <!-- Withdraw Form -->
<section class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 mb-6"
         x-data="{ showModal: false, amount: '', withdraw: 0, submitted: false }" x-cloak>

  <h2 class="text-lg font-semibold text-green-700 dark:text-green-300 mb-4">💳 Enter Amount</h2>

  <form @submit.prevent="
          if(amount >= 550){ 
            withdraw = amount; 
            submitted = false; 
            showModal = true 
          } else { 
            alert('Minimum withdraw is 550') 
          }" 
        class="space-y-4">

    <input type="number" x-model="amount" min="550"
  placeholder="Enter Amount (min 550)" 
  class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-3 
         focus:outline-none focus:ring-2 focus:ring-green-400
         text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">

    <button type="submit" 
      class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">
      Withdraw Now
    </button>
  </form>

  <!-- Modal -->
  <div x-show="showModal" 
       x-transition.opacity
       class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
       @click.self="showModal = false">

    <div x-show="showModal" x-transition
         class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg w-full max-w-md p-6 relative">

      <!-- Close Button -->
      <button @click="showModal = false" 
              class="absolute top-3 right-3 text-gray-500 hover:text-red-500">
        ✕
      </button>

      <!-- Show Form if not submitted -->
      <template x-if="!submitted">
        <div>
          <h3 class="text-lg font-semibold text-green-700 dark:text-green-300 mb-4">
            🏦 Withdraw Request
          </h3>

          <!-- Withdrawable Amount -->
          <p class="text-center text-lg font-bold text-gray-800 dark:text-gray-200 mb-3">
            💰 Withdraw Amount: <span class="text-green-600">₹ <span x-text="withdraw"></span></span>
          </p>

          <!-- Saved Bank Details -->
          <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg mb-4 text-sm text-gray-700 dark:text-gray-300">
            <p><strong>Bank:</strong> HDFC Bank</p>
            <p><strong>Account No:</strong> XXXX1234</p>
            <p><strong>IFSC:</strong> HDFC0000123</p>
          </div>

          <!-- Confirm Button -->
          <form @submit.prevent="submitted = true">
            <button type="submit" 
              class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">
              Confirm Withdraw
            </button>
          </form>
        </div>
      </template>

      <!-- Success Message -->
      <template x-if="submitted">
        <div class="text-center space-y-4">
          <div class="text-green-600 text-4xl">✅</div>
          <h3 class="text-lg font-semibold text-green-700 dark:text-green-300">
            Withdraw request submitted successfully!
          </h3>
          <p class="text-gray-600 dark:text-gray-300">
            Your request will be processed soon.
          </p>
          <button @click="showModal = false" 
                  class="mt-4 w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">
            Close
          </button>
        </div>
      </template>

    </div>
  </div>
</section>

<!-- Alpine.js -->
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


    <!-- Withdraw History -->
    <section class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 overflow-x-auto">
      <h2 class="text-lg font-semibold text-green-700 dark:text-green-300 mb-4">📋 Withdraw History</h2>
      <table class="w-full border-collapse text-sm">
        <thead>
          <tr class="bg-green-100 dark:bg-gray-700 text-green-800 dark:text-green-300">
            <th class="border p-2">ID</th>
            <th class="border p-2">Amount</th>
            <th class="border p-2">Date</th>
            <th class="border p-2">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr class="text-center">
            <td class="border p-2">-</td>
            <td class="border p-2">-</td>
            <td class="border p-2">-</td>
            <td class="border p-2">-</td>
          </tr>
        </tbody>
      </table>
    </section>
  </main>

  <!-- Bottom Nav (Mobile) -->
  <nav class="fixed bottom-0 left-0 right-0 bg-green-700 dark:bg-green-900 text-white flex justify-around py-3 md:hidden">
    <a href="dashboard.php">🏠</a>
    <a href="wallet.php">💰</a>
    <a href="plans.php">📋</a>
    
    <a href="profile.php">👤</a>
  </nav>

</body>
</html>
