<?php
include '../includes/init.php';

// Logout logic
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    $_SESSION = [];
    session_destroy();
    header("Location: index.php");
    exit();
}

// Redirect if not logged in
if (!isset($_SESSION['userid'])) {
    header("Location: index.php");
    exit();
}

$userid = $_SESSION['userid'];

// Fetch data
$accountdata = $user->getaccounts($userid); // should return single row or null
$walletdata  = $wallet->getWalletBalance($userid);
$userdata    = $admin->selectDataWithConditions('users', null, ['userid' => $userid]);

// Handle bank form submission
if (isset($_POST['bank'])) {
    $accountNumber   = isset($_POST['account_number']) ? htmlspecialchars(trim($_POST['account_number'])) : '';
    $ifsc            = isset($_POST['ifsc_code']) ? htmlspecialchars(trim($_POST['ifsc_code'])) : '';
    $bankName        = isset($_POST['bank_name']) ? htmlspecialchars(trim($_POST['bank_name'])) : '';
    $bankAccountName = isset($_POST['account_name']) ? htmlspecialchars(trim($_POST['account_name'])) : '';

    // Save (insert or update)
    $user->updatebankData($bankAccountName, $accountNumber, $ifsc, $userid, $bankName);

    // Refresh account data
    $accountdata = $user->getaccounts($userid);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bank - Agri Invest</title>
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
        <p class="text-sm text-green-200">Welcome, <?php echo htmlspecialchars($userdata[0]['name'] ?? 'User'); ?> 👨‍🌾</p>
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

  <!-- Main -->
  <main class="flex-1 md:ml-64 p-6">
    <!-- Navbar -->
    <header class="flex items-center justify-between mb-6 relative">
      <h1 class="text-xl font-bold text-green-800 dark:text-green-300">Bank Account</h1>
      <div class="flex items-center gap-4">
        <button onclick="toggleTheme()" class="bg-gray-200 dark:bg-yellow-400 px-3 py-1 rounded-lg">🌗</button>
        <div class="relative">
          <img id="profileBtn" onclick="toggleProfileMenu()" src="images/profile.jpg" class="w-10 h-10 rounded-full border shadow cursor-pointer">
          <div id="profileMenu" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden z-50">
            <a href="profile.php" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">👤 Profile</a>
            <a href="settings.php" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">⚙️ Settings</a>
            <a href="dashboard.php?logout=true" class="block px-4 py-2 text-red-500 hover:bg-gray-100 dark:hover:bg-gray-700">🚪 Logout</a>
          </div>
        </div>
      </div>
    </header>

    <!-- Bank Form -->
    <section class="p-6">
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
        <h2 class="text-lg font-semibold text-green-700 dark:text-green-400 mb-4">Add / Update Bank Account</h2>
        <form class="space-y-4" method="post" action="">
          <div>
            <label class="block text-gray-600 dark:text-gray-300">Account Holder Name</label>
            <input type="text" name="account_name" value="<?php echo htmlspecialchars($accountdata['bank_account_name'] ?? ''); ?>" placeholder="Enter full name" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-600 dark:bg-gray-700 dark:border-gray-600">
          </div>
          <div>
            <label class="block text-gray-600 dark:text-gray-300">Account Number</label>
            <input type="text" name="account_number" value="<?php echo htmlspecialchars($accountdata['bank_account_number'] ?? ''); ?>" placeholder="Enter account number" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-600 dark:bg-gray-700 dark:border-gray-600">
          </div>
          <div>
            <label class="block text-gray-600 dark:text-gray-300">IFSC Code</label>
            <input type="text" name="ifsc_code" value="<?php echo htmlspecialchars($accountdata['ifsc_code'] ?? ''); ?>" placeholder="Enter IFSC" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-600 dark:bg-gray-700 dark:border-gray-600">
          </div>
          <div>
            <label class="block text-gray-600 dark:text-gray-300">Bank Name</label>
            <input type="text" name="bank_name" value="<?php echo htmlspecialchars($accountdata['bank_name'] ?? ''); ?>" placeholder="Enter bank name" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-600 dark:bg-gray-700 dark:border-gray-600">
          </div>
          <button type="submit" name="bank" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">Save Bank</button>
        </form>
      </div>
    </section>

    <!-- Saved Accounts -->
    <section class="p-6 flex-1">
      <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-3">Saved Bank Account</h2>
      <?php if (!empty($accountdata)) { ?>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 flex justify-between items-center">
          <div>
            <p class="font-bold text-green-700 dark:text-green-400"><?php echo htmlspecialchars($accountdata['bank_name']); ?></p>
            <p class="text-gray-600 dark:text-gray-400 text-sm">Account No: <?php echo htmlspecialchars($accountdata['bank_account_number']); ?></p>
            <p class="text-gray-600 dark:text-gray-400 text-sm">IFSC: <?php echo htmlspecialchars($accountdata['ifsc_code']); ?></p>
          </div>
          <form method="post" action="remove_bank.php">
            <input type="hidden" name="userid" value="<?php echo $userid; ?>">
            <button type="submit" class="text-red-500 hover:text-red-700">Remove</button>
          </form>
        </div>
      <?php } else { ?>
        <p class="text-gray-500 dark:text-gray-400">No bank account saved yet.</p>
      <?php } ?>
    </section>
  </main>

   <!-- Bottom Nav (Mobile) -->
  <nav class="fixed bottom-0 left-0 right-0 bg-green-700 dark:bg-green-900 text-white flex justify-around py-3 md:hidden shadow-lg">
    <a href="dashboard.php">🏠</a>
    <a href="wallet.php">💰</a>
    <a href="plans.php">📋</a>
    
    <a href="profile.php">👤</a>
  </nav>
</body>
</html>
