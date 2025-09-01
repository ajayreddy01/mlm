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
$id = $userdata[0]['id'];
if (isset($_POST['submit'])) {
  $name = checkinput($_POST['name']);
  $phn = checkinput($_POST['phn']);
  $email = checkinput($_POST['email']);

  $admin->updateData('users', ['name' => $name, 'phone_number' => $phn, 'email' => $email],  $id);
  // Refresh user data
  $userdata = $admin->selectDataWithConditions('users', null, ['userid' => $_SESSION['userid']]);
}
if (isset($_POST['changepass'])) {
  $pass = password_hash(checkinput($_POST['pass']), PASSWORD_BCRYPT);
  $admin->updateData('users', ['password' => $pass],  $id);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Settings - Agri Invest</title>
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
        <p class="text-lg font-bold">🌱 Agri Invest</p>
        <p class="text-sm text-green-200">Welcome, <?php echo $userdata[0]['name'] ?> 👨‍🌾</p>
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
  <div id="mobileSidebar"
    class="hidden fixed top-0 left-0 w-64 h-full bg-green-700 dark:bg-green-900 text-white p-6 space-y-6 z-50">
    <div class="flex items-center justify-between">
      <div class="flex items-center gap-3">
        <img src="images/profile.jpg" class="w-12 h-12 rounded-full border-2 border-white shadow">
        <div>
          <p class="text-lg font-bold">🌱 Agri Invest</p>
          <p class="text-sm text-green-200">Welcome, <?php echo $userdata[0]['name'] ?> 👨‍🌾</p>
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
        <h1 class="text-xl font-bold text-green-800 dark:text-green-300">Settings</h1>
      </div>
      <div class="flex items-center gap-4">
        <button onclick="toggleTheme()" class="bg-gray-200 dark:bg-yellow-400 px-3 py-1 rounded-lg">🌗</button>

        <!-- Notifications -->
        

        <!-- Profile -->
        <div class="relative">
          <img id="profileBtn" onclick="toggleProfileMenu()" src="images/profile.jpg"
            class="w-10 h-10 rounded-full border shadow cursor-pointer">
          <div id="profileMenu"
            class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden z-50">
            <!-- <a href="profile.php" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">👤 Profile</a> -->
            <a href="whatsapp.php" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">📱 WhatsApp
              Group</a>
            <a href="settings.php" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">⚙️ Settings</a>
            <a href="dashboard.php?logout=true"
              class="block px-4 py-2 text-red-500 hover:bg-gray-100 dark:hover:bg-gray-700">🚪 Logout</a>
          </div>
        </div>
      </div>
    </header>
    <!-- Settings Section -->
    <main class="p-6 flex-1">
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 max-w-2xl mx-auto space-y-8">

        <form action="" method="post">
          <div>
            <h2 class="text-lg font-semibold text-green-700 dark:text-green-400 mb-4">👤 Profile Information</h2>
            <div class="space-y-4">
              <div>
                <label class="block text-gray-600 dark:text-gray-300">Full Name</label>
                <input type="text" name="name" id="name" value="<?php echo $userdata[0]['name'] ?>"
                  class="w-full border rounded-lg px-4 py-2 dark:bg-gray-700 dark:text-white">
              </div>
              <div>
                <label class="block text-gray-600 dark:text-gray-300">Mobile Number</label>
                <input type="text" name="phn" id="phn" value="<?php echo $userdata[0]['phone_number'] ?>"
                  class="w-full border rounded-lg px-4 py-2 dark:bg-gray-700 dark:text-white">
              </div>
              <div>
                <label class="block text-gray-600 dark:text-gray-300">Email Address</label>
                <input type="email" name="email" id="email" value="<?php echo $userdata[0]['email'] ?>"
                  class="w-full border rounded-lg px-4 py-2 dark:bg-gray-700 dark:text-white">
              </div>
            </div>
          </div>
          <!-- Save All -->
          <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
            <button type="submit" name="submit" id="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-medium">💾 Save All
              Changes</button>
          </div>
        </form>


        <form action="" method="post">
          <div>
            <h2 class="text-lg font-semibold text-green-700 dark:text-green-400 mb-4">🔑 Change Password</h2>
            <div class="space-y-4">
              <div>
                <label class="block text-gray-600 dark:text-gray-300">New Password</label>
                <input name="pass" type="password" placeholder="Enter new password"
                  class="w-full border rounded-lg px-4 py-2 dark:bg-gray-700 dark:text-white">
              </div>
              <div>
                <label class="block text-gray-600 dark:text-gray-300">Confirm Password</label>
                <input name="pass" type="password" placeholder="Re-enter new password"
                  class="w-full border rounded-lg px-4 py-2 dark:bg-gray-700 dark:text-white">
              </div>
              <button type="submit" name="changepass" id="changepass"
                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Update Password</button>
            </div>
          </div>
        </form>
        <!-- Password Change -->


        <!-- Preferences -->
        <!-- <div>
      <h2 class="text-lg font-semibold text-green-700 dark:text-green-400 mb-4">🔔 Notifications</h2>
      <div class="space-y-3">
        <div class="flex items-center justify-between">
          <span>Email Notifications</span>
          <input type="checkbox" checked class="w-5 h-5">
        </div>
        <div class="flex items-center justify-between">
          <span>SMS Notifications</span>
          <input type="checkbox" class="w-5 h-5">
        </div>
        <div class="flex items-center justify-between">
          <span>App Push Notifications</span>
          <input type="checkbox" checked class="w-5 h-5">
        </div>
      </div>
      <button class="mt-3 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Save Preferences</button>
    </div> -->

        <!-- Language -->
        <!-- <div>
      <h2 class="text-lg font-semibold text-green-700 dark:text-green-400 mb-4">🌐 Language</h2>
      <div class="flex items-center gap-4">
        <select class="w-full border rounded-lg px-4 py-2 dark:bg-gray-700 dark:text-white">
          <option selected>English</option>
          <option>हिन्दी</option>
          <option>తెలుగు</option>
          <option>தமிழ்</option>
        </select>
        <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Save</button>
      </div>
    </div> -->

        <!-- Theme -->
        <!-- <div class="flex justify-between items-center">
      <h2 class="text-lg font-semibold text-green-700 dark:text-green-400">🌗 Theme Mode</h2>
      <button onclick="toggleTheme()" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">Toggle Dark/Light</button>
    </div> -->

        <!-- Logout -->
        <div class="pt-2">
          <a href="dashboard.php?logout=true"
            class="w-full block text-center bg-red-500 text-white py-2 rounded-lg hover:bg-red-600">🚪 Logout</a>
        </div>
      </div>
    </main>

    </div>

    <!-- Bottom Navigation (mobile) -->
    <nav
      class="fixed bottom-0 left-0 right-0 bg-green-700 dark:bg-green-900 text-white flex justify-around py-3 md:hidden shadow-lg">
      <a href="dashboard.php">🏠</a>
      <a href="wallet.php">💰</a>
      <a href="plans.php">📋</a>

      <a href="profile.php">👤</a>
    </nav>
</body>

</html>