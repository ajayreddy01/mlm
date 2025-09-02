<?php
include '../includes/init.php';
$links = include  '../includes/social.php';
$whtsapplink = $links['whatsapp'];
$telelink   = $links['telegram'];
if (isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id'])) {
    $id = $_SESSION['admin_id'];
} else {
    // User is not logged in, redirect to index.php
    header("Location: index.php");
    exit();
}
?>
<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="<?php echo BASE_URL; ?>/assets/"
    data-template="vertical-menu-template-no-customizer" data-style="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Demo : Dashboard - Analytics | sneat - Bootstrap Dashboard PRO</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_URL; ?>/assets/img/favicon/favicon.ico" />
    <?php echo $template_admin->head_includes(); ?>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <?php echo $template_admin->side_nav(); ?>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <?php echo $template_admin->header(); ?>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">

                        <!-- Target Meter -->
                        <div class="row">
                            <div class="col-lg-4 mb-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div class="d-flex flex-column">
                                                <div class="card-title mb-auto">
                                                    <h5 class="mb-0">Target Meter</h5>
                                                    <p class="mb-0">Total Report</p>
                                                </div>
                                                <div class="chart-statistics">
                                                    <h4 class="card-title mb-0" id="targetMeterTotal">0</h4>
                                                </div>
                                            </div>
                                            <div id="leadsReportChart" data-plans="0" data-lottery="0"
                                                data-total-percentage="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 mb-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div class="d-flex flex-column">
                                                <div class="card-title mb-auto">
                                                    <form method="POST" action="update_links.php">
                                                        <label>WhatsApp Link</label>
                                                        <input class="form-control" type="url" name="whatsapp" id="whatsapp"
                                                            value="<?php echo htmlspecialchars($whtsapplink); ?>"
                                                            required>

                                                        <label>Telegram Link</label>
                                                        <input type="url" class="form-control"name="telegram" id="telegram"
                                                            value="<?php echo htmlspecialchars($telelink); ?>" required>

                                                        <button type="submit">Update Links</button>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Stats Row -->
                            <div class="row">
                                <!-- Total Sales -->
                                <div class="col-lg-4 col-md-6 col-sm-6 mb-6">
                                    <div class="card">
                                        <div class="card-header d-flex align-items-center justify-content-between">
                                            <h6 class="card-title fw-normal m-0 me-2">Total Sales</h6>
                                            <div class="dropdown">
                                                <button class="btn btn-text text-muted p-0" type="button"
                                                    id="totalSalesList" data-bs-toggle="dropdown">
                                                    Today <i class="bx bx-chevron-down"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="updateStat('total_sales','totalSalesValue','totalSalesList','today')">Today</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="updateStat('total_sales','totalSalesValue','totalSalesList','this_week')">This
                                                        Week</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="updateStat('total_sales','totalSalesValue','totalSalesList','this_month')">This
                                                        Month</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="updateStat('total_sales','totalSalesValue','totalSalesList','all_time')">All
                                                        Time</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="d-flex justify-content-center mb-3">
                                                <div class="avatar avatar-md flex-shrink-0">
                                                    <span class="avatar-initial avatar-shadow-primary rounded-circle">
                                                        <i class="bx bx-trending-up bx-26px"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <h4 class="card-title mb-0" id="totalSalesValue">₹0</h4>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Deposits -->
                                <div class="col-lg-4 col-md-6 col-sm-6 mb-6">
                                    <div class="card">
                                        <div class="card-header d-flex align-items-center justify-content-between">
                                            <h6 class="card-title fw-normal m-0 me-2">Total Deposits
                                            </h6>
                                            <div class="dropdown">
                                                <button class="btn btn-text text-muted p-0" type="button"
                                                    id="totalDepositsList" data-bs-toggle="dropdown">
                                                    Today <i class="bx bx-chevron-down"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="updateStat('total_deposits','totalDepositsValue','totalDepositsList','today')">Today</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="updateStat('total_deposits','totalDepositsValue','totalDepositsList','this_week')">This
                                                        Week</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="updateStat('total_deposits','totalDepositsValue','totalDepositsList','this_month')">This
                                                        Month</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="updateStat('total_deposits','totalDepositsValue','totalDepositsList','all_time')">All
                                                        Time</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="d-flex justify-content-center mb-3">
                                                <div class="avatar avatar-md flex-shrink-0">
                                                    <span class="avatar-initial avatar-shadow-success rounded-circle">
                                                        <i class="bx bx-dollar bx-26px"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <h4 class="card-title mb-0" id="totalDepositsValue">₹0</h4>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Withdrawals -->
                                <div class="col-lg-4 col-md-6 col-sm-6 mb-6">
                                    <div class="card">
                                        <div class="card-header d-flex align-items-center justify-content-between">
                                            <h6 class="card-title fw-normal m-0 me-2">Total Withdrawals
                                            </h6>
                                            <div class="dropdown">
                                                <button class="btn btn-text text-muted p-0" type="button"
                                                    id="totalWithdrawalsList" data-bs-toggle="dropdown">
                                                    Today <i class="bx bx-chevron-down"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="updateStat('total_withdrawals','totalWithdrawalsValue','totalWithdrawalsList','today')">Today</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="updateStat('total_withdrawals','totalWithdrawalsValue','totalWithdrawalsList','this_week')">This
                                                        Week</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="updateStat('total_withdrawals','totalWithdrawalsValue','totalWithdrawalsList','this_month')">This
                                                        Month</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="updateStat('total_withdrawals','totalWithdrawalsValue','totalWithdrawalsList','all_time')">All
                                                        Time</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="d-flex justify-content-center mb-3">
                                                <div class="avatar avatar-md flex-shrink-0">
                                                    <span class="avatar-initial avatar-shadow-info rounded-circle">
                                                        <i class="bx bx-dollar bx-26px"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <h4 class="card-title mb-0" id="totalWithdrawalsValue">₹0
                                            </h4>
                                        </div>
                                    </div>
                                </div>

                                <!-- New Customers -->
                                <div class="col-lg-4 col-md-6 col-sm-6 mb-6">
                                    <div class="card">
                                        <div class="card-header d-flex align-items-center justify-content-between">
                                            <h6 class="card-title fw-normal m-0 me-2">New Customers</h6>
                                            <div class="dropdown">
                                                <button class="btn btn-text text-muted p-0" type="button"
                                                    id="newCustomersList" data-bs-toggle="dropdown">
                                                    Today <i class="bx bx-chevron-down"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="updateStat('new_customers','newCustomersValue','newCustomersList','today')">Today</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="updateStat('new_customers','newCustomersValue','newCustomersList','this_week')">This
                                                        Week</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="updateStat('new_customers','newCustomersValue','newCustomersList','this_month')">This
                                                        Month</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="updateStat('new_customers','newCustomersValue','newCustomersList','all_time')">All
                                                        Time</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="d-flex justify-content-center mb-3">
                                                <div class="avatar avatar-md flex-shrink-0">
                                                    <span class="avatar-initial avatar-shadow-success rounded-circle">
                                                        <i class="bx bx-user bx-26px"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <h4 class="card-title mb-0" id="newCustomersValue">0</h4>
                                        </div>
                                    </div>
                                </div>

                                <!-- Lottery Sales -->
                                <div class="col-lg-4 col-md-6 col-sm-6 mb-6">
                                    <div class="card">
                                        <div class="card-header d-flex align-items-center justify-content-between">
                                            <h6 class="card-title fw-normal m-0 me-2">Lottery Sales</h6>
                                            <div class="dropdown">
                                                <button class="btn btn-text text-muted p-0" type="button"
                                                    id="lotterySalesList" data-bs-toggle="dropdown">
                                                    Today <i class="bx bx-chevron-down"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="updateStat('lottery_sales','lotterySalesValue','lotterySalesList','today')">Today</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="updateStat('lottery_sales','lotterySalesValue','lotterySalesList','this_week')">This
                                                        Week</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="updateStat('lottery_sales','lotterySalesValue','lotterySalesList','this_month')">This
                                                        Month</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="updateStat('lottery_sales','lotterySalesValue','lotterySalesList','all_time')">All
                                                        Time</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="d-flex justify-content-center mb-3">
                                                <div class="avatar avatar-md flex-shrink-0">
                                                    <span class="avatar-initial avatar-shadow-success rounded-circle">
                                                        <i class="bx bxs-coupon bx-26px"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <h4 class="card-title mb-0" id="lotterySalesValue">₹0</h4>
                                        </div>
                                    </div>
                                </div>

                                <!-- Lottery Withdrawals -->
                                <div class="col-lg-4 col-md-6 col-sm-6 mb-6">
                                    <div class="card">
                                        <div class="card-header d-flex align-items-center justify-content-between">
                                            <h6 class="card-title fw-normal m-0 me-2">Lottery
                                                Withdrawals</h6>
                                            <div class="dropdown">
                                                <button class="btn btn-text text-muted p-0" type="button"
                                                    id="lotteryWithdrawalsList" data-bs-toggle="dropdown">
                                                    Today <i class="bx bx-chevron-down"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="updateStat('lottery_withdrawals','lotteryWithdrawalsValue','lotteryWithdrawalsList','today')">Today</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="updateStat('lottery_withdrawals','lotteryWithdrawalsValue','lotteryWithdrawalsList','this_week')">This
                                                        Week</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="updateStat('lottery_withdrawals','lotteryWithdrawalsValue','lotteryWithdrawalsList','this_month')">This
                                                        Month</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="updateStat('lottery_withdrawals','lotteryWithdrawalsValue','lotteryWithdrawalsList','all_time')">All
                                                        Time</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="d-flex justify-content-center mb-3">
                                                <div class="avatar avatar-md flex-shrink-0">
                                                    <span class="avatar-initial avatar-shadow-info rounded-circle">
                                                        <i class="bx bxs-coupon bx-26px"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <h4 class="card-title mb-0" id="lotteryWithdrawalsValue">₹0
                                            </h4>
                                        </div>
                                    </div>
                                </div>

                            </div> <!-- end row -->
                        </div>

                        <!-- / Content -->

                        <!-- Footer -->
                        <?php echo $template_admin->footer(); ?>
                        <!-- / Footer -->

                        <div class="content-backdrop fade"></div>
                    </div>
                    <!-- Content wrapper -->
                </div>
                <!-- / Layout page -->
            </div>

            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>

            <!-- Drag Target Area To SlideIn Menu On Small Screens -->
            <div class="drag-target"></div>
        </div>
        <!-- / Layout wrapper -->

        <?php echo $template_admin->body_includes(); ?>
        <script src="<?php echo BASE_URL; ?>/assets/user-js/cards-statistics.js"></script>
        <script>
            let dashboardData = {};

            function loadDashboard() {
                fetch("https://agriinvestharvest.com/api/admin/getDashboardStats")
                    .then(response => response.json())
                    .then(data => {
                        dashboardData = data;

                        // Default values = today
                        updateStat('total_sales', 'totalSalesValue', 'totalSalesList', 'today');
                        updateStat('total_deposits', 'totalDepositsValue', 'totalDepositsList', 'today');
                        updateStat('total_withdrawals', 'totalWithdrawalsValue', 'totalWithdrawalsList', 'today');
                        updateStat('new_customers', 'newCustomersValue', 'customersList', 'today');
                        updateStat('lottery_sales', 'lotterySalesValue', 'lotterySalesList', 'today');
                        updateStat('lottery_withdrawals', 'lotteryWithdrawalsValue', 'lotteryWithdrawalsList', 'today');

                        // Target Meter
                        const target = data.target_meter;
                        if (target) {
                            const chartEl = document.getElementById("leadsReportChart");
                            chartEl.setAttribute("data-plans", target.plans);
                            chartEl.setAttribute("data-lottery", target.lottery);
                            chartEl.setAttribute("data-total-percentage", target.total_percentage);
                        }
                    })
                    .catch(error => console.error("Error loading dashboard:", error));
            }

            function updateStat(key, elementId, buttonId, period) {
                if (dashboardData[key] && dashboardData[key][period] !== undefined) {
                    // update card value
                    document.getElementById(elementId).innerText =
                        (key === 'new_customers' ? '' : '₹') + dashboardData[key][period];

                    // update dropdown label
                    document.getElementById(buttonId).innerHTML =
                        period.replace("_", " ").replace(/\b\w/g, c => c.toUpperCase()) +
                        ' <i class="bx bx-chevron-down"></i>';
                }
            }

            window.addEventListener("DOMContentLoaded", loadDashboard);
        </script>

</body>

</html>