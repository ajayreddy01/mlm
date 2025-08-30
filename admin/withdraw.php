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
                    <div id="toast-container"></div>
                        <!-- Responsive Datatable -->
                        <div class="card">
                            <h5 class="card-header pb-0 text-md-start text-center">Withdraw</h5>
                            <div class="card-datatable table-responsive">
                                <table class="dt-responsive table border-top" id="withdraw_table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>User Id</th>
                                            <th>Transaction ID</th>
                                            <th>Name</th>
                                            <th>Amount</th>
                                            <th>BANKING NAME</th>
                                            <th>Bank Account Number</th>
                                            <th>IFSC CODE</th>
                                            <th>Action</th>
                                            <th>Acrion</th>
                                           
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>User Id</th>
                                            <th>Transaction ID</th>
                                            <th>Name</th>
                                            <th>Amount</th>
                                            <th>BANKING NAME</th>
                                            <th>Bank Account Number</th>
                                            <th>IFSC CODE</th>
                                            <th>Action</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <!--/ Responsive Datatable -->
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
    <script src="<?php echo BASE_URL ?>/assets/js/withdraw.js?1"></script>

    
</body>

</html>