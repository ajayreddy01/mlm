<?php
include '../includes/init.php';

// 🔐 Logout logic
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    $_SESSION = [];
    session_destroy();
    header("Location: index.php");
    exit();
}

// 🔐 If not logged in, redirect
if (!isset($_SESSION['userid'])) {
    header("Location: index.php");
    exit();
}

$userid     = $_SESSION['userid'];
$walletdata = $wallet->getWalletBalance($userid);
$userdata   = $admin->selectDataWithConditions('users', null, ['userid' => $userid]);

// 💰 Amount validation
$amount = $_GET['amount'] ?? 0;
if ($amount <= 500) {
    header("Location: deposit.php");
    exit();
}

// 🏦 Get bank info
$bankdata = $bank->selectbank($amount);

// ⚡ Handle form submission
$submitted = false;
$errorMsg  = '';

if (isset($_POST['submit'])) {
    $utrNumber = trim($_POST['utr'] ?? '');

    if (!empty($utrNumber) && isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Upload screenshot
        $uploadFile = $admin->uploadImage($_FILES['image']);

        // Build data
        $data = [
            'bank_id'    => $bankdata['id'],
            'bank_name'  => $bankdata['name'],
            'utr_number' => $utrNumber,
            'image'      => $uploadFile,
            'remarks'    => trim($_POST['remarks'] ?? '')
        ];

        // Save deposit
        $wallet->deposit($userid, $amount, $data);

        $submitted = true;
    } else {
        $errorMsg = "❌ Please provide both UTR Number and an image.";
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Submit UTR</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen text-gray-900 dark:text-gray-100 flex">

  <!-- Sidebar -->
  <aside class="hidden md:flex md:flex-col fixed top-0 left-0 w-64 h-screen bg-green-700 dark:bg-green-900 text-white p-6 space-y-6">
    <div class="flex items-center gap-3">
      <img src="images/profile.jpg" class="w-12 h-12 rounded-full border-2 border-white shadow">
      <div>
        <p class="text-lg font-bold">🌱 Agri Invest</p>
        <p class="text-sm text-green-200">Welcome, <?php echo htmlspecialchars($userdata[0]['name'] ?? 'User'); ?> 👨‍🌾</p>
      </div>
    </div>
    <nav class="flex flex-col space-y-3 mt-6">
      <a href="dashboard.php" class="hover:bg-green-600 p-2 rounded">🏠 Dashboard</a>
      <a href="wallet.php" class="hover:bg-green-600 p-2 rounded">💰 Wallet</a>
      <a href="plans.php" class="hover:bg-green-600 p-2 rounded">📋 Plans</a>
      <a href="luckydraw.php" class="hover:bg-green-600 p-2 rounded">🎁 Lucky Draw</a>
      <a href="tasks.php" class="hover:bg-green-600 p-2 rounded">✅ Tasks</a>
      <a href="bank.php" class="hover:bg-green-600 p-2 rounded">🏦 Bank</a>
      <a href="invite.php" class="hover:bg-green-600 p-2 rounded">🤝 Invite</a>
      <a href="deposit.php" class="hover:bg-green-600 p-2 rounded">⬆️ Deposit</a>
      <a href="withdraw.php" class="hover:bg-green-600 p-2 rounded">⬇️ Withdraw</a>
    </nav>
  </aside>

  <!-- Main -->
  <main class="flex-1 md:ml-64 p-6 flex justify-center">
    <section class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 w-full max-w-md"
             x-data="{ submitted: <?php echo $submitted ? 'true' : 'false'; ?>, 
                       file: null, 
                       preview: '' }">

      <!-- Step Indicator -->
      <div class="flex items-center justify-between mb-4">
        <span class="text-green-600 font-semibold">Step 2/2</span>
        <span class="text-sm text-gray-500 dark:text-gray-400">Submit UTR</span>
      </div>

      <!-- Error Message -->
      <?php if (!empty($errorMsg)): ?>
        <p class="mb-3 text-red-600 font-medium"><?php echo $errorMsg; ?></p>
      <?php endif; ?>

      <!-- Form -->
      <template x-if="!submitted">
        <div>
          <h2 class="text-xl font-bold text-green-700 dark:text-green-300 mb-4">📲 Complete Your Payment</h2>

          <!-- Amount -->
          <p class="text-center text-lg font-bold text-gray-800 dark:text-gray-200 mb-3">
            💰 Payable Amount: <span class="text-green-600">₹ <?php echo htmlspecialchars($amount); ?></span>
          </p>

          <!-- QR Code -->
          <div class="flex justify-center mb-4">
            <img src="<?php echo BASE_URL . $bankdata['image']; ?>" alt="QR Code" class="rounded-lg shadow-md">
          </div>

          <!-- Payment Form -->
          <form method="post" enctype="multipart/form-data" class="space-y-4">
            <input type="text" name="utr" placeholder="Enter UTR Number" required
                   class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-green-400">

            <textarea name="remarks" placeholder="Remarks (optional)" rows="2"
                      class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-green-400"></textarea>

            <!-- Upload Screenshot -->
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload Screenshot</label>
              <input type="file" name="image" accept="image/*" required
                     @change="file = $event.target.files[0]; preview = URL.createObjectURL(file)"
                     class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-green-400">

              <!-- Preview -->
              <template x-if="preview">
                <img :src="preview" alt="Preview"
                     class="mt-3 rounded-lg shadow-md w-full max-h-56 object-contain">
              </template>
            </div>

            <div class="flex gap-3">
              <a href="deposit.php" class="w-1/2 text-center bg-gray-300 dark:bg-gray-700 py-3 rounded-xl">⬅ Back</a>
              <button type="submit" name="submit"
                      class="w-1/2 bg-green-600 text-white py-3 rounded-xl font-semibold hover:bg-green-700">
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
             class="mt-4 block w-full bg-green-600 text-white py-3 rounded-xl hover:bg-green-700 font-semibold">
            Back to Deposit
          </a>
        </div>
      </template>
    </section>
  </main>
</body>
</html>
