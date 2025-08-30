<!doctype html>
<?php
include '../includes/init.php';
if (isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
} 
?>
<html
    lang="en"
    class="light-style layout-wide customizer-hide"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="<?php echo BASE_URL;?>/assets/"
    data-template="vertical-menu-template-no-customizer"
    data-style="light">

<head>
    <meta charset="utf-8" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_URL;?>/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="<?php echo BASE_URL;?>/assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL;?>/assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL;?>/assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL;?>/assets/vendor/css/rtl/core.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL;?>/assets/vendor/css/rtl/theme-default.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL;?>/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL;?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL;?>/assets/vendor/libs/typeahead-js/typeahead.css" />
    <!-- Vendor -->
    <link rel="stylesheet" href="<?php echo BASE_URL;?>/assets/vendor/libs/@form-validation/form-validation.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="<?php echo BASE_URL;?>/assets/vendor/css/pages/page-auth.css" />

    <!-- Helpers -->
    <script src="<?php echo BASE_URL;?>/assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?php echo BASE_URL;?>/assets/js/config.js"></script>
</head>

<body>
    <!-- Content -->

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card px-sm-6 px-0">
                    <div class="card-body">
                        
                        <h4 class="mb-1">Welcome to Agri Invest! </h4>
                        <p class="mb-6">Please sign-in to your account and start the adventure</p>

                        <form id="formAuthentication" class="mb-6" action="<?php echo BASE_URL;?>api/admin/login" method="POST">
                            <div class="mb-6">
                                <label for="email" class="form-label">Email or Username</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    placeholder="Enter your email or username"
                                    autofocus />
                            </div>
                            <div class="mb-6 form-password-toggle">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group input-group-merge">
                                    <input
                                        type="password"
                                        id="password"
                                        class="form-control"
                                        name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                           
                            <div class="mb-6">
                                <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="<?php echo BASE_URL;?>/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="<?php echo BASE_URL;?>/assets/vendor/libs/popper/popper.js"></script>
    <script src="<?php echo BASE_URL;?>/assets/vendor/js/bootstrap.js"></script>
    <script src="<?php echo BASE_URL;?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?php echo BASE_URL;?>/assets/vendor/libs/hammer/hammer.js"></script>
    <script src="<?php echo BASE_URL;?>/assets/vendor/libs/i18n/i18n.js"></script>
    <script src="<?php echo BASE_URL;?>/assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="<?php echo BASE_URL;?>/assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="<?php echo BASE_URL;?>/assets/vendor/libs/@form-validation/popular.js"></script>
    <script src="<?php echo BASE_URL;?>/assets/vendor/libs/@form-validation/bootstrap5.js"></script>
    <script src="<?php echo BASE_URL;?>/assets/vendor/libs/@form-validation/auto-focus.js"></script>

    <!-- Main JS -->
    <script src="<?php echo BASE_URL;?>/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="<?php echo BASE_URL;?>/assets/js/pages-auth.js"></script>
</body>

</html>