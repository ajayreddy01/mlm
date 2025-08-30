<!DOCTYPE html>
<html lang="en" class="transition-colors duration-300">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Transactions - FarmerApp</title>
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

  <<!-- Sidebar (Desktop - Fixed) -->
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
        <h1 class="text-xl font-bold text-green-800 dark:text-green-300">Transactions</h1>
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


    <!-- Page content -->
    <div class="w-full max-w-screen-xl mx-auto px-4 md:px-6 py-6 space-y-6">

      <!-- Balance Summary -->
      <section class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-4">
          <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400">Balance</p>
          <p class="text-2xl md:text-3xl font-extrabold tabular-nums text-green-700 dark:text-green-400">₹ 12,500.00</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-4">
          <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400">Deposit Balance</p>
          <p class="text-2xl md:text-3xl font-extrabold tabular-nums text-green-700 dark:text-green-400">₹ 8,000.00</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-4">
          <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400">Withdraw Balance</p>
          <p class="text-2xl md:text-3xl font-extrabold tabular-nums text-green-700 dark:text-green-400">₹ 3,000.00</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-4">
          <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400">Bonus Balance</p>
          <p class="text-2xl md:text-3xl font-extrabold tabular-nums text-green-700 dark:text-green-400">₹ 1,500.00</p>
        </div>
      </section>

      <!-- Manage Funds -->
      <section class="bg-white dark:bg-gray-800 rounded-2xl shadow p-4 md:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
          <h2 class="text-sm md:text-base text-gray-600 dark:text-gray-300">Manage Funds</h2>
          <div class="flex flex-wrap gap-2">
            <a href="deposit.php" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl text-sm">⬆️ Deposit</a>
            <a href="withdraw.php" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-xl text-sm">⬇️ Withdraw</a>
          </div>
        </div>
      </section>

      <!-- Filters (optional) -->
      <section class="flex flex-col sm:flex-row gap-3">
        <input type="text" placeholder="Search by ID or type…" class="bg-white dark:bg-gray-800 dark:text-gray-200 rounded-xl shadow px-4 py-2 w-full sm:w-72 focus:outline-none focus:ring-2 focus:ring-green-500">
        <select class="bg-white dark:bg-gray-800 dark:text-gray-200 rounded-xl shadow px-4 py-2 w-full sm:w-56 focus:outline-none focus:ring-2 focus:ring-green-500">
          <option value="">All Status</option>
          <option>Success</option>
          <option>Pending</option>
          <option>Failed</option>
        </select>
      </section>

      <!-- Transactions -->
      <section class="space-y-4">
        <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">All Transactions</h2>

        <!-- Desktop Table -->
        <div class="hidden md:block bg-white dark:bg-gray-800 rounded-2xl shadow overflow-x-auto">
          <table class="w-full text-left text-sm">
            <thead class="bg-green-600 text-white">
              <tr>
                <th class="py-3 px-4">ID</th>
                <th class="py-3 px-4">Type</th>
                <th class="py-3 px-4 text-right">Amount</th>
                <th class="py-3 px-4">Date</th>
                <th class="py-3 px-4">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y dark:divide-gray-700">
              <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                <td class="py-3 px-4">#001</td>
                <td class="py-3 px-4">Deposit</td>
                <td class="py-3 px-4 text-right tabular-nums text-green-600 font-semibold">+ ₹5,000.00</td>
                <td class="py-3 px-4">2025-08-18</td>
                <td class="py-3 px-4"><span class="bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300 px-2 py-1 rounded-lg text-xs">Success</span></td>
              </tr>
              <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                <td class="py-3 px-4">#002</td>
                <td class="py-3 px-4">Withdraw</td>
                <td class="py-3 px-4 text-right tabular-nums text-red-600 font-semibold">- ₹2,000.00</td>
                <td class="py-3 px-4">2025-08-15</td>
                <td class="py-3 px-4"><span class="bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300 px-2 py-1 rounded-lg text-xs">Success</span></td>
              </tr>
              <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                <td class="py-3 px-4">#003</td>
                <td class="py-3 px-4">Plan Purchase</td>
                <td class="py-3 px-4 text-right tabular-nums text-yellow-700 font-semibold">- ₹1,500.00</td>
                <td class="py-3 px-4">2025-08-12</td>
                <td class="py-3 px-4"><span class="bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-300 px-2 py-1 rounded-lg text-xs">Pending</span></td>
              </tr>
              <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                <td class="py-3 px-4">#004</td>
                <td class="py-3 px-4">Deposit</td>
                <td class="py-3 px-4 text-right tabular-nums text-green-600 font-semibold">+ ₹3,000.00</td>
                <td class="py-3 px-4">2025-08-10</td>
                <td class="py-3 px-4"><span class="bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300 px-2 py-1 rounded-lg text-xs">Success</span></td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Mobile Cards -->
        <div class="md:hidden grid grid-cols-1 gap-4">
          <!-- Card -->
          <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
            <div class="flex items-center justify-between">
              <p class="text-sm text-gray-500 dark:text-gray-400">#001 • Deposit</p>
              <span class="bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300 px-2 py-1 rounded text-xs">Success</span>
            </div>
            <p class="mt-2 text-lg font-semibold text-green-600">+ ₹5,000.00</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">2025-08-18</p>
          </div>

          <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
            <div class="flex items-center justify-between">
              <p class="text-sm text-gray-500 dark:text-gray-400">#002 • Withdraw</p>
              <span class="bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300 px-2 py-1 rounded text-xs">Success</span>
            </div>
            <p class="mt-2 text-lg font-semibold text-red-600">- ₹2,000.00</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">2025-08-15</p>
          </div>

          <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
            <div class="flex items-center justify-between">
              <p class="text-sm text-gray-500 dark:text-gray-400">#003 • Plan Purchase</p>
              <span class="bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-300 px-2 py-1 rounded text-xs">Pending</span>
            </div>
            <p class="mt-2 text-lg font-semibold text-yellow-700">- ₹1,500.00</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">2025-08-12</p>
          </div>

          <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
            <div class="flex items-center justify-between">
              <p class="text-sm text-gray-500 dark:text-gray-400">#004 • Deposit</p>
              <span class="bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300 px-2 py-1 rounded text-xs">Success</span>
            </div>
            <p class="mt-2 text-lg font-semibold text-green-600">+ ₹3,000.00</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">2025-08-10</p>
          </div>
        </div>
      </section>

      <!-- Bottom spacing to avoid overlap with mobile nav -->
      <div class="h-16 md:h-0"></div>
    </div>

    <!-- Bottom nav (mobile) -->
    <nav class="fixed bottom-0 left-0 right-0 z-20 bg-green-700 dark:bg-green-900 text-white flex justify-around py-3 md:hidden shadow-lg">
      <a href="dashboard.php">🏠</a>
      <a href="wallet.php">💰</a>
      <a href="plans.php">📋</a>
      <a href="transactions.php" class="font-bold">📑</a>
      <a href="profile.php">👤</a>
    </nav>
  </main>
</body>
</html>
