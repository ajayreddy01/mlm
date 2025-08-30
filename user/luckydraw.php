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
<html lang="en" class="transition-colors duration-300">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Lucky Draw - Agri Invest</title>
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

    window.addEventListener("click", function (e) {
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

<body class="bg-gray-100 dark:bg-gray-900 min-h-screen flex flex-col text-gray-900 dark:text-gray-100">

  <!-- Sidebar (Desktop - Fixed) -->
  <aside
    class="hidden md:flex md:flex-col fixed top-0 left-0 w-64 h-screen bg-green-700 dark:bg-green-900 text-white p-6 space-y-6">
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
  <div id="sidebarOverlay" class="hidden fixed inset-0 bg-black/50 z-40" onclick="toggleSidebar()"></div>
  <div id="mobileSidebar"
    class="fixed top-0 left-0 w-64 h-full bg-green-700 dark:bg-green-900 text-white p-6 space-y-6 z-50 transform -translate-x-full transition-transform duration-300 md:hidden">
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
  <main class="flex-1 md:ml-64 p-6 pb-20"> <!-- pb-20 avoids bottom nav overlap -->
    <!-- Navbar -->
    <header class="flex items-center justify-between mb-6 relative">
      <div class="flex items-center gap-4">
        <!-- Mobile Sidebar Button -->
        <button id="sidebarBtn" onclick="toggleSidebar()" class="md:hidden text-2xl">☰</button>
        <h1 class="text-xl font-bold text-green-800 dark:text-green-300">Lucky Draw</h1>
      </div>
      <div class="flex items-center gap-4">
        <button onclick="toggleTheme()" class="bg-gray-200 dark:bg-yellow-400 px-3 py-1 rounded-lg">🌗</button>

        <!-- Notifications -->
        <div class="relative">
          <button id="notifBtn" onclick="toggleNotifMenu()" class="relative cursor-pointer">
            🔔
            <span class="absolute -top-1 -right-1 bg-red-500 text-xs text-white px-1 rounded-full">3</span>
          </button>
          <div id="notifMenu"
            class="hidden absolute right-0 mt-2 w-72 bg-white dark:bg-gray-800 rounded-xl shadow-lg z-50">
            <div class="p-3 border-b dark:border-gray-700 font-semibold">Notifications</div>
            <div class="max-h-60 overflow-y-auto">
              <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">💰 You received ₹500
                in Wallet</a>
              <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">✅ Task "Water wheat
                field" is pending</a>
              <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">🎁 Lucky Draw #124124
                starts today</a>
              <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">⚠️ Update your bank
                account details</a>
            </div>
            <div class="p-2 text-center border-t dark:border-gray-700">
              <a href="notifications.php" class="text-green-600 dark:text-green-400 text-sm font-medium">View All</a>
            </div>
          </div>
        </div>

        <!-- Profile -->
        <div class="relative">
          <img id="profileBtn" onclick="toggleProfileMenu()" src="images/profile.jpg"
            class="w-10 h-10 rounded-full border shadow cursor-pointer">
          <div id="profileMenu"
            class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden z-50">
            <a href="profile.php" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">👤 Profile</a>
            <a href="whatsapp.php" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">📱 WhatsApp
              Group</a>
            <a href="settings.php" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">⚙️ Settings</a>
            <a href="dashboard.php?logout=true"
              class="block px-4 py-2 text-red-500 hover:bg-gray-100 dark:hover:bg-gray-700">🚪 Logout</a>
          </div>
        </div>
      </div>
    </header>


    <!-- Page Content -->
    <div class="max-w-screen-xl mx-auto w-full px-4 py-6 space-y-8">

      <!-- Lucky Draw Cards -->
      <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <?php
        // Fetch lotteries from API
        $apiUrl = "http://laxfuel.in/api/user/getalllottery";
        $response = file_get_contents($apiUrl);
        $lotteries = json_decode($response, true);

        if ($lotteries && is_array($lotteries)) {
          foreach ($lotteries as $row) {
            echo '
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
        <!-- Banner Image -->
        <div class="h-40 w-full">
          <img src="images/luckydraw.png" 
               alt="Lucky Draw Banner" 
               class="w-full h-full object-cover">
        </div>

        <!-- Card Content -->
        <div class="p-6 text-center">
          <h2 class="text-xl font-bold text-green-700 dark:text-green-400">' . htmlspecialchars($row['name']) . '</h2>
          <p class="text-gray-500 dark:text-gray-400 text-sm mb-3">' . htmlspecialchars($row['description'] ?? "Try your luck and win big! 🍀") . '</p>

          <div class="space-y-2 text-gray-700 dark:text-gray-300 text-sm">
            <p><span class="font-medium">Entry Fee:</span> ₹' . htmlspecialchars($row['ticket']) . '</p>
            <p><span class="font-medium">Cycle:</span> ' . htmlspecialchars($row['type']) . '</p>
            <p><span class="font-medium">Prize:</span> ₹' . htmlspecialchars($row['winning']) . '</p>
          </div>

          <button onclick="buylottery(event)" 
                  data-id="' . htmlspecialchars($row['id']) . '" 
                  data-userid="' . htmlspecialchars($_SESSION['userid']) . '" 
                  data-amount="' . htmlspecialchars($row['ticket']) . '" 
                  class="mt-4 bg-green-600 text-white px-6 py-2 rounded-xl hover:bg-green-700">
            Join Lucky Draw
          </button>
        </div>
      </div>';
          }
        } else {
          echo '<div class="col-span-2 text-center text-gray-500 dark:text-gray-400">No lotteries available at the moment.</div>';
        }
        ?>
      </section>


      <!-- Lucky Draw History -->
      <section class="mt-8">
        <div class="flex items-center justify-between mb-3">
          <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Lucky Draw History</h2>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow overflow-x-auto">
          <table class="w-full text-sm text-left">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
              <tr>
                <th class="p-3">ID</th>
                <th class="p-3">Lucky Draw Name</th>
                <th class="p-3 text-right">Amount</th>
                <th class="p-3">Ticket</th>
                <th class="p-3">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
              <?php
              $data = $user->getlotterydata($_SESSION['userid']);
              if ($data && count($data) > 0) {
                foreach ($data as $row) {
                  // Status badge color
                  $statusClass = '';
                  switch (strtolower($row['status'])) {
                    case 'active':
                      $statusClass = 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300';
                      break;
                    case 'pending':
                      $statusClass = 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-300';
                      break;
                    case 'lost':
                    case 'cancelled':
                      $statusClass = 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300';
                      break;
                    default:
                      $statusClass = 'bg-gray-100 text-gray-700 dark:bg-gray-900/40 dark:text-gray-300';
                  }

                  echo '
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
              <td class="p-3">#' . htmlspecialchars($row['id']) . '</td>
              <td class="p-3">' . htmlspecialchars($row['name']) . '</td>
              <td class="p-3 text-right text-green-600 font-medium">₹' . htmlspecialchars($row['price']) . '</td>
              <td class="p-3">#' . htmlspecialchars($row['ticket_number']) . '</td>
              <td class="p-3">
                <span class="' . $statusClass . ' px-2 py-1 rounded-lg text-xs">' . ucfirst($row['status']) . '</span>
              </td>
            </tr>';
                }
              } else {
                echo '<tr><td colspan="5" class="p-3 text-center text-gray-500 dark:text-gray-400">No lottery history found.</td></tr>';
              }
              ?>
            </tbody>
          </table>
        </div>
      </section>

    </div>

  </main>

  <!-- Bottom nav (mobile) -->
  <nav
    class="fixed bottom-0 left-0 right-0 z-30 bg-green-700 dark:bg-green-900 text-white flex justify-around py-3 md:hidden shadow-lg">
    <a href="dashboard.php">🏠</a>
    <a href="wallet.php" class="font-bold">💰</a>
    <a href="plans.php">📋</a>
    <a href="transactions.php">📑</a>
    <a href="profile.php">👤</a>
  </nav>

  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById("mobileSidebar");
      const overlay = document.getElementById("sidebarOverlay");
      sidebar.classList.toggle("-translate-x-full");
      overlay.classList.toggle("hidden");
    }
  </script>
</body>

</html>