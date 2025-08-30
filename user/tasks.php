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
<html lang="en"> <!-- Add 'dark' here if you want default dark -->

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

<body class="bg-gray-100 dark:bg-gray-900 min-h-screen flex text-gray-900 dark:text-gray-100">

  <!-- Sidebar (Desktop - Fixed) -->
  <aside
    class="hidden md:flex md:flex-col fixed top-0 left-0 w-64 h-screen bg-green-700 dark:bg-green-900 text-white p-6 space-y-6">
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
  <div id="mobileSidebar"
    class="hidden fixed top-0 left-0 w-64 h-full bg-green-700 dark:bg-green-900 text-white p-6 space-y-6 z-50">
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





    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Invite Task</h3>

    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php
      // Fetch API
      function fetchApi($url)
      {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
      }

      $apiUrl = "https://agriinvestharvest.com/api/user/getallschemes";
      $response = fetchApi($apiUrl);
      $schemes = json_decode($response, true);

      // User referral progress + referral link
      $todayReferred = $refer->getTodaysReferrals($_SESSION['userid']);
      $referralUrl = "https://agriinvestharvest.com/user/signup.php?invite_code=" . urlencode($userdata[0]['referral_code']);

      if (!empty($schemes) && is_array($schemes)) {
        var_dump($schemes);
        foreach ($schemes as $row) {
          // Completion logic
          $isCompleted = $todayReferred >= (int) $row['number_of_refers'];
          $progress = min(100, round(($todayReferred / (int) $row['number_of_refers']) * 100));

          // Buttons
          if (!$isCompleted) {
            $inviteBtn = '
          <button data-refer_link="' . $referralUrl . '" 
                  onclick="copyToClipboard(this)" 
                  class="w-full bg-yellow-500 text-white py-2 rounded-xl hover:bg-yellow-600 transition">
            📋 Copy Invite Link
          </button>';
          } else {
            $inviteBtn = '
          <button class="w-full bg-gray-400 text-white py-2 rounded-xl cursor-not-allowed">
            ✅ Completed
          </button>';
          }

          echo '
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 flex flex-col justify-between">
        <div>
          <h5 class="text-lg font-bold text-green-700 dark:text-green-300 mb-2">' . htmlspecialchars($row['scheme_name']) . '</h5>
          <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
            Invite <span class="font-bold">' . htmlspecialchars($row['number_of_refers']) . '</span> members and earn 
            <span class="font-bold text-green-600">₹' . htmlspecialchars($row['winning_prize']) . '</span>
          </p>

          <!-- Progress -->
          <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 mb-3">
            <div class="bg-green-500 h-2.5 rounded-full" style="width: ' . $progress . '%"></div>
          </div>
          <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">' . $todayReferred . ' / ' . htmlspecialchars($row['number_of_refers']) . ' invited</p>
        </div>

        <div class="space-y-2">
          ' . $inviteBtn . '
          <a href="https://wa.me/?text=Join%20AgriInvest%20using%20my%20link:%20' . urlencode($referralUrl) . '" 
             target="_blank"
             class="block w-full bg-green-600 text-white py-2 rounded-xl hover:bg-green-700 transition">
            💬 Share on WhatsApp
          </a>
          <a href="sms:?body=Join%20AgriInvest%20using%20my%20link:%20' . $referralUrl . '" 
             class="block w-full bg-yellow-500 text-white py-2 rounded-xl hover:bg-yellow-600 transition">
            ✉️ Share via SMS
          </a>
        </div>
      </div>';
        }
      } else {
        echo '<p class="col-span-3 text-center text-gray-500 dark:text-gray-400">No invite tasks available right now.</p>';
      }
      ?>
    </section>

    <script>
      function copyToClipboard(btn) {
        let link = btn.getAttribute("data-refer_link");
        navigator.clipboard.writeText(link).then(() => {
          let toast = document.createElement("div");
          toast.innerText = "Referral link copied!";
          toast.className = "fixed bottom-5 right-5 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg text-sm";
          document.body.appendChild(toast);
          setTimeout(() => toast.remove(), 2000);
        });
      }
    </script>


    <script>
      function copyToClipboard(btn) {
        let link = btn.getAttribute("data-refer_link");
        navigator.clipboard.writeText(link).then(() => {
          let toast = document.createElement("div");
          toast.innerText = "Referral link copied!";
          toast.className = "fixed bottom-5 right-5 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg text-sm";
          document.body.appendChild(toast);
          setTimeout(() => toast.remove(), 2000);
        });
      }
    </script>





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