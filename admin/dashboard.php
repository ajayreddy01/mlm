<?php
include '../includes/init.php';
if (isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id'])) {
    $id = $_SESSION['admin_id'];
} else {
    // User is not logged in, redirect to index.php
    header("Location: index.php");
    exit();
}
?>
<!doctype html>

<html
    lang="en"
    class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="<?php echo BASE_URL; ?>/assets/"
    data-template="vertical-menu-template-no-customizer"
    data-style="light">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
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
                                                    <h4 class="card-title mb-0">4,230</h4>

                                                </div>
                                            </div>
                                            <div id="leadsReportChart"
                                                data-plans="50"
                                                data-lottery="10"
                                                data-total-percentage="60">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-6 mb-6">
                                <div class="card">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h6 class="card-title fw-normal m-0 me-2">Total Sales</h6>
                                        <div class="dropdown">
                                            <button class="btn btn-text text-muted p-0" type="button" id="totalSalesList" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Today <i class="bx bx-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="totalSalesList">
                                                <a class="dropdown-item" href="javascript:void(0);">This Week</a>
                                                <a class="dropdown-item" href="javascript:void(0);">This Month</a>
                                                <a class="dropdown-item" href="javascript:void(0);">All Time</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="d-flex justify-content-center mb-3">
                                            <div class="avatar avatar-md flex-shrink-0">
                                                <span class="avatar-initial avatar-shadow-primary rounded-circle"><i class="bx bx-trending-up bx-26px"></i></span>
                                            </div>
                                        </div>
                                        <h4 class="card-title mb-0">&#x20B9; 8,352</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6 mb-6">
                                <div class="card">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h6 class="card-title fw-normal m-0 me-2">Total Deposits</h6>
                                        <div class="dropdown">
                                            <button class="btn btn-text text-muted p-0" type="button" id="referralsList" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Today <i class="bx bx-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="referralsList">
                                                <a class="dropdown-item" href="javascript:void(0);">This Week</a>
                                                <a class="dropdown-item" href="javascript:void(0);">This Month</a>
                                                <a class="dropdown-item" href="javascript:void(0);">All Time</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="d-flex justify-content-center mb-3">
                                            <div class="avatar avatar-md flex-shrink-0">
                                                <span class="avatar-initial avatar-shadow-success rounded-circle"><i class="bx bx-dollar bx-26px"></i></span>
                                            </div>
                                        </div>
                                        <h4 class="card-title mb-0">&#x20B9;1,271</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6 mb-6">
                                <div class="card">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h6 class="card-title fw-normal m-0 me-2">Total withdraw's</h6>
                                        <div class="dropdown">
                                            <button class="btn btn-text text-muted p-0" type="button" id="referralsList" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Today <i class="bx bx-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="referralsList">
                                                <a class="dropdown-item" href="javascript:void(0);">This Week</a>
                                                <a class="dropdown-item" href="javascript:void(0);">This Month</a>
                                                <a class="dropdown-item" href="javascript:void(0);">All Time</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="d-flex justify-content-center mb-3">
                                            <div class="avatar avatar-md flex-shrink-0">
                                                <span class="avatar-initial avatar-shadow-info rounded-circle"><i class="bx bx-dollar bx-26px"></i></span>
                                            </div>
                                        </div>
                                        <h4 class="card-title mb-0">&#x20B9;1,271</h4>

                                        <!-- <span class="text-danger">-23% <i class="bx bx-chevron-down bx-lg"></i></span> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6 mb-6">
                                <div class="card">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h6 class="card-title fw-normal m-0 me-2">New Customers</h6>
                                        <div class="dropdown">
                                            <button class="btn btn-text text-muted p-0" type="button" id="customersList" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Today <i class="bx bx-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="customersList">
                                                <a class="dropdown-item" href="javascript:void(0);">This Week</a>
                                                <a class="dropdown-item" href="javascript:void(0);">This Month</a>
                                                <a class="dropdown-item" href="javascript:void(0);">All Time</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="d-flex justify-content-center mb-3">
                                            <div class="avatar avatar-md flex-shrink-0">
                                                <span class="avatar-initial avatar-shadow-success rounded-circle"><i class="bx bx-user bx-26px"></i></span>
                                            </div>
                                        </div>
                                        <h4 class="card-title mb-0">24,680</h4>

                                        <!-- <span class="text-success">+42% <i class="bx bx-chevron-up bx-lg"></i></span> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6 mb-6">
                                <div class="card">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h6 class="card-title fw-normal m-0 me-2">Lottery Sales</h6>
                                        <div class="dropdown">
                                            <button class="btn btn-text text-muted p-0" type="button" id="referralsList" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Today <i class="bx bx-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="referralsList">
                                                <a class="dropdown-item" href="javascript:void(0);">This Week</a>
                                                <a class="dropdown-item" href="javascript:void(0);">This Month</a>
                                                <a class="dropdown-item" href="javascript:void(0);">All Time</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="d-flex justify-content-center mb-3">
                                            <div class="avatar avatar-md flex-shrink-0">
                                                <span class="avatar-initial avatar-shadow-success rounded-circle"><i class="bx bxs-coupon bx-26px"></i></span>
                                            </div>
                                        </div>
                                        <h4 class="card-title mb-0">&#x20B9;1,271</h4>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-6 mb-6">
                                <div class="card">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h6 class="card-title fw-normal m-0 me-2">Lottery withdraw's</h6>
                                        <div class="dropdown">
                                            <button class="btn btn-text text-muted p-0" type="button" id="referralsList" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Today <i class="bx bx-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="referralsList">
                                                <a class="dropdown-item" href="javascript:void(0);">This Week</a>
                                                <a class="dropdown-item" href="javascript:void(0);">This Month</a>
                                                <a class="dropdown-item" href="javascript:void(0);">All Time</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="d-flex justify-content-center mb-3">
                                            <div class="avatar avatar-md flex-shrink-0">
                                                <span class="avatar-initial avatar-shadow-info rounded-circle"><i class="bx bxs-coupon bx-26px"></i></span>
                                            </div>
                                        </div>
                                        <h4 class="card-title mb-0">&#x20B9;1,271</h4>

                                    </div>
                                </div>
                            </div>
                        </div>


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
</body>

</html>