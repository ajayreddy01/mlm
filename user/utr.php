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

$walletdata = $wallet->getWalletBalance($_SESSION['userid']);
$amount = $_GET['amount'] ?? 0;
if ($amount <= 500) {
  header("Location: deposit.php");
  exit();
}
$bankdata = $bank->selectbank($amount);


// Handle form submission
if (isset($_POST['submit'])) {
  $utrNumber = $_POST['utr'] ?? '';


  // Check and handle file upload
  if (!empty($utrNumber) && isset($_FILES['image'])) {
    $uploadFile = $admin->uploadImage($_FILES['image']);
    $data = [
      'bank_id' => $bankdata['id'],
      'bank_name' => $bankdata['name'],
      'utr_number' => $utrNumber,
      'image' => $uploadFile
    ];
    
    $wallet->deposit($_SESSION['userid'], $amount, $data);
    //header('Location: https://agriinvestharvest.com/user/dashbaord.php');
    //exit;
  } else {
    echo "Please provide both UTR Number and an image.";
  }
}
?><!DOCTYPE html>
<html lang="en" class="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Submit UTR</title>
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
  <div id="mobileSidebar"
    class="hidden fixed top-0 left-0 w-64 h-full bg-green-700 dark:bg-green-900 text-white p-6 space-y-6 z-50">
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
        <h1 class="text-xl font-bold text-green-800 dark:text-green-300">Profile</h1>
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


    <section class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 w-full max-w-md"
      x-data="{ amount: new URLSearchParams(window.location.search).get('amount') || 0, submitted: <?php echo isset($_POST['submit']) ? 'true' : 'false'; ?> }">

      <!-- Step Indicator -->
      <div class="flex items-center justify-between mb-4">
        <span class="text-green-600 font-semibold">Step 2/2</span>
        <span class="text-sm text-gray-500 dark:text-gray-400">Submit UTR</span>
      </div>

      <!-- UTR Form -->
      <template x-if="!submitted">
        <div>
          <h2 class="text-xl font-bold text-green-700 dark:text-green-300 mb-4">📲 Complete Your Payment</h2>

          <!-- Payable Amount -->
          <p class="text-center text-lg font-bold text-gray-800 dark:text-gray-200 mb-3">
            💰 Payable Amount: <span class="text-green-600">₹ <span x-text="amount"></span></span>
          </p>

          <!-- QR Code -->
          <div class="flex justify-center mb-4">
            <img src="<?php echo BASE_URL . $bankdata['image']; ?>" alt="QR Code" class="rounded-lg shadow-md">
          </div>

          <!-- Payment Form -->
          <form class="space-y-4" method="post" enctype="multipart/form-data">
            <input type="text" placeholder="Enter UTR Number" name="utr" id="utr" required class="w-full border border-gray-300 dark:border-gray-600 rounded-xl p-3 
                 focus:outline-none focus:ring-2 focus:ring-green-400">

            <textarea name="remarks" placeholder="Remarks (optional)" rows="2" class="w-full border border-gray-300 dark:border-gray-600 rounded-xl p-3 
                 focus:outline-none focus:ring-2 focus:ring-green-400"></textarea>

            <!-- Upload Screenshot -->
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload Screenshot</label>
              <input type="file" name="image" id="image" accept="image/*" required class="w-full border border-gray-300 dark:border-gray-600 rounded-xl p-3
                   focus:outline-none focus:ring-2 focus:ring-green-400">
            </div>

            <div class="flex gap-3">
              <a href="deposit.php"
                class="w-1/2 text-center bg-gray-300 dark:bg-gray-700 text-gray-900 dark:text-gray-100 py-3 rounded-xl hover:bg-gray-400 dark:hover:bg-gray-600 transition">
                ⬅ Back
              </a>
              <button type="submit" name="submit" id="submit"
                class="w-1/2 bg-green-600 text-white py-3 rounded-xl font-semibold hover:bg-green-700 transition">
                Submit
              </button>
            </div>
          </form>
        </div>
      </template>

      <!-- Success Message -->
      <template x-if="submitted">
        <div class="text-center space-y-4">
          <div class="text-green-600 text-5xl">✅</div>
          <h3 class="text-lg font-semibold text-green-700 dark:text-green-300">
            Payment details submitted successfully!
          </h3>
          <p class="text-gray-600 dark:text-gray-300">We’ll verify and update your wallet soon.</p>
          <a href="deposit.php"
            class="mt-4 block w-full bg-green-600 text-white py-3 rounded-xl hover:bg-green-700 text-center transition font-semibold">
            Back to Deposit
          </a>
        </div>
      </template>
    </section>


    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>

</html>