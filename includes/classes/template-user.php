<?php
class user_template
{
    protected $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function header() {}

    public function footer() {
        return '
         <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl">
                            <div
                                class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                                <div class="text-body">
                                    ©
                                    <script>
                                        document.write(new Date().getFullYear());
                                    </script>
                                    , made with ❤️ by
                                    <a href="#" class="footer-link">VKTSR</a>
                                </div>

                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->
        ';
    }

    public function  head_includes()
    {
        return '
        
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="' . BASE_URL . '/assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="' . BASE_URL . '/assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="' . BASE_URL . '/assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="' . BASE_URL . '/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="' . BASE_URL . '/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="' . BASE_URL . '/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="' . BASE_URL . '/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="' . BASE_URL . '/assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="' . BASE_URL . '/assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="' . BASE_URL . '/assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="' . BASE_URL . '/assets/js/config.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
<style>
    .mobile-navbar {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: #f8f9fa;
        box-shadow: 0 -1px 5px rgba(0, 0, 0, 0.1);
        z-index: 1030;
    }

    .mobile-navbar .nav-item {
        text-align: center;
        flex-grow: 1;
    }

    .mobile-navbar .nav-link {
        color: #000;
        font-size: 14px;
    }

    .mobile-navbar .nav-link:hover {
        color: #007bff;
    }

    .option-card {
        text-align: center;
        padding: 20px;
        border: 1px solid #f0f0f0;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .option-card:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .icon-custom {
        color: #696cff;
    }

    .option-card i {
        font-size: 2rem;
        color: #007bff;
    }

    .option-card h6 {
        margin-top: 10px;
        font-size: 1rem;
        color: #333;
    }
</style>
        ';
    }

    public function body_includes() {
        return '
        
    <script src="' . BASE_URL . '/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="' . BASE_URL . '/assets/vendor/libs/popper/popper.js"></script>
    <script src="' . BASE_URL . '/assets/vendor/js/bootstrap.js"></script>
    <script src="' . BASE_URL . '/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="' . BASE_URL . '/assets/vendor/libs/hammer/hammer.js"></script>
    <script src="' . BASE_URL . '/assets/vendor/libs/i18n/i18n.js"></script>
    <script src="' . BASE_URL . '/assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="' . BASE_URL . '/assets/vendor/js/menu.js"></script>

    <!-- endbuild -->


    <!-- Main JS -->
    <script src="' . BASE_URL . '/assets/js/main.js"></script>
    <script src="' . BASE_URL . '/assets/js/user-defined.js?v=8"></script>
        ';
    }

    public function side_nav() {
        return '<aside id="layout-menu" class="layout-menu-horizontal align-items-center  menu-horizontal menu bg-menu-theme flex-grow-0">
                        <div class="container-xxl align-items-center d-flex h-100">

                            <ul class="menu-inner ">

                                <li class="menu-item ">
                                    <a href="index.php" class="menu-link ">
                                        <i class="menu-icon tf-icons bx bx-home-smile"></i>
                                        <div data-i18n="Dashboards">Dashboards</div>
                                    </a>
                                </li>


                                <li class="menu-item">
                                    <a href="plans.php" class="menu-link">
                                        <i class="menu-icon tf-icons bx bx-rupee"></i>
                                        <div data-i18n="Plans">Plans</div>
                                    </a>
                                </li>


                                <li class="menu-item">
                                    <a href="lottery.php" class="menu-link ">
                                        <i class="menu-icon tf-icons bx bxs-coupon"></i>
                                        <div data-i18n="Lucky Draw">Lucky Draw</div>
                                    </a>

                                </li>

                                <li class="menu-item">
                                    <a href="wallet.php" class="menu-link">
                                        <i class="menu-icon tf-icons bx bx-wallet"></i>
                                        <div data-i18n="Wallet">Wallet</div>
                                    </a>

                                </li>

                                <li class="menu-item">
                                    <a href="tasks.php" class="menu-link">
                                        <i class="menu-icon tf-icons bx bx-task"></i>
                                        <div data-i18n="Tasks">Tasks</div>
                                    </a>

                                </li>
                                <li class="menu-item">
                                    <a href="refer.php" class="menu-link">
                                        <i class="menu-icon tf-icons bx bx-user-plus"></i>
                                        <div data-i18n="Refer and Earn">Refer and Earn</div>
                                    </a>

                                </li>

                               
                                <li class="menu-item">
                                    <a class="menu-link" href="https://chat.whatsapp.com/IFkIyJm2wO5BhA7zFP24H8" target="_blank">
                                        <i class="menu-icon bx bxl-whatsapp "></i>
                                        <div>Whatsapp Group</div>
                                    </a>
                                </li>


                            </ul>
                        </div>
                    </aside>
                    <div id="alert-container" class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
                    <!-- Alerts will be dynamically added here -->
                    </div>

                    ';
    }

    public function top_nav(){
        return '<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
                <div class="container-xxl">
                    <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
                        <a href="index.php" class="app-brand-link">
                            <img src="'.BASE_URL.'assets/img/logo.png" width="90" height="100" alt="vktsr_logo" srcset="">
                        </a>

                        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
                            <i class="d-flex align-items-center justify-content-center"></i>
                        </a>
                    </div>

                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                            <i class="bx bx-menu bx-md"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <ul class="navbar-nav flex-row align-items-center ms-auto">

                        
                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a
                                    class="nav-link dropdown-toggle hide-arrow p-0"
                                    href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="' . BASE_URL . '/assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="pages-account-settings-account.html">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="' . BASE_URL . '/assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">'.$_SESSION["name"].'</h6>
                                                    
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider my-1"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="profile.php" >
                                            <i class="bx bx-user bx-md me-3"></i><span>My Profile</span>
                                        </a>
                                    </li>
                                   

                                   
                                    <li>
                                        <div class="dropdown-divider my-1"></div>
                                    </li>
                                   
                                    <li>
                                        <a class="dropdown-item" href="https://chat.whatsapp.com/IFkIyJm2wO5BhA7zFP24H8" target="_blank">
                                            <i class="bx bxl-whatsapp bx-md me-3"></i><span>Whatsapp Group</span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider my-1"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="?logout=true">
                                            <i class="bx bx-power-off bx-md me-3"></i><span>Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </div>
            </nav>
            

               




                <!-- Password Change Modal -->
<div class="modal fade" id="passwordChangeModal" tabindex="-1" aria-labelledby="passwordChangeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="passwordChangeModalLabel">Change Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">
        <form id="passwordChangeForm" method="POST" action="change_password.php">
          <!-- Current Password -->
          <div class="mb-3">
            <label for="currentPassword" class="form-label">Current Password</label>
            <input type="password" class="form-control" id="currentPassword" name="current_password" placeholder="Enter your current password" required>
          </div>
          <!-- New Password -->
          <div class="mb-3">
            <label for="newPassword" class="form-label">New Password</label>
            <input type="password" class="form-control" id="newPassword" name="new_password" placeholder="Enter your new password" required>
          </div>
          <!-- Confirm New Password -->
          <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirm New Password</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirm_password" placeholder="Re-enter your new password" required>
          </div>
        
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" form="passwordChangeForm" class="btn btn-primary">Change Password</button>
      </div>
      </form>
    </div>
  </div>
</div>


            ';
    }
}
