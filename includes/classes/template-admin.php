<?php
class admin_template
{
  protected $pdo;
  public function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  public function header()
  {
    return '
        <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                <i class="bx bx-menu bx-md"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <div class="navbar-nav align-items-center">
                <div class="nav-item navbar-search-wrapper mb-0">
                  <a class="nav-item nav-link search-toggler px-0" href="javascript:void(0);">
                    <i class="bx bx-search bx-md"></i>
                    <span class="d-none d-md-inline-block text-muted fw-normal ms-4">Search (Ctrl+/)</span>
                  </a>
                </div>
              </div>
              <!-- /Search -->

             
                <!-- /Language -->

                <!-- Quick links  -->
                <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-2 me-xl-0">
                  <a
                    class="nav-link dropdown-toggle hide-arrow"
                    href="javascript:void(0);"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="outside"
                    aria-expanded="false">
                    <i class="bx bx-grid-alt bx-md"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-end p-0">
                    <div class="dropdown-menu-header border-bottom">
                      <div class="dropdown-header d-flex align-items-center py-3">
                        <h6 class="mb-0 me-auto">Shortcuts</h6>
                        <a
                          href="javascript:void(0)"
                          class="dropdown-shortcuts-add py-2"
                          data-bs-toggle="tooltip"
                          data-bs-placement="top"
                          title="Add shortcuts"
                          ><i class="bx bx-plus-circle text-heading"></i
                        ></a>
                      </div>
                    </div>
                    <div class="dropdown-shortcuts-list scrollable-container">
                      <div class="row row-bordered overflow-visible g-0">
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="bx bx-calendar bx-26px text-heading"></i>
                          </span>
                          <a href="app-calendar.html" class="stretched-link">Calendar</a>
                          <small>Appointments</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="bx bx-food-menu bx-26px text-heading"></i>
                          </span>
                          <a href="app-invoice-list.html" class="stretched-link">Invoice App</a>
                          <small>Manage Accounts</small>
                        </div>
                      </div>
                      <div class="row row-bordered overflow-visible g-0">
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="bx bx-user bx-26px text-heading"></i>
                          </span>
                          <a href="app-user-list.html" class="stretched-link">User App</a>
                          <small>Manage Users</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="bx bx-check-shield bx-26px text-heading"></i>
                          </span>
                          <a href="app-access-roles.html" class="stretched-link">Role Management</a>
                          <small>Permission</small>
                        </div>
                      </div>
                      <div class="row row-bordered overflow-visible g-0">
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="bx bx-pie-chart-alt-2 bx-26px text-heading"></i>
                          </span>
                          <a href="index.html" class="stretched-link">Dashboard</a>
                          <small>User Dashboard</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="bx bx-cog bx-26px text-heading"></i>
                          </span>
                          <a href="pages-account-settings-account.html" class="stretched-link">Setting</a>
                          <small>Account Settings</small>
                        </div>
                      </div>
                      <div class="row row-bordered overflow-visible g-0">
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="bx bx-help-circle bx-26px text-heading"></i>
                          </span>
                          <a href="pages-faq.html" class="stretched-link">FAQs</a>
                          <small>FAQs & Articles</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                            <i class="bx bx-window-open bx-26px text-heading"></i>
                          </span>
                          <a href="modal-examples.html" class="stretched-link">Modals</a>
                          <small>Useful Popups</small>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <!-- Quick links -->

                <!-- Notification -->
                <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
                  <a
                    class="nav-link dropdown-toggle hide-arrow"
                    href="javascript:void(0);"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="outside"
                    aria-expanded="false">
                    <span class="position-relative">
                      <i class="bx bx-bell bx-md"></i>
                      <span class="badge rounded-pill bg-danger badge-dot badge-notifications border"></span>
                    </span>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end p-0">
                    <li class="dropdown-menu-header border-bottom">
                      <div class="dropdown-header d-flex align-items-center py-3">
                        <h6 class="mb-0 me-auto">Notification</h6>
                        <div class="d-flex align-items-center h6 mb-0">
                          <span class="badge bg-label-primary me-2">8 New</span>
                          <a
                            href="javascript:void(0)"
                            class="dropdown-notifications-all p-2"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="Mark all as read"
                            ><i class="bx bx-envelope-open text-heading"></i
                          ></a>
                        </div>
                      </div>
                    </li>
                    <li class="dropdown-notifications-list scrollable-container">
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item list-group-item-action dropdown-notifications-item">
                          <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                              <div class="avatar">
                                <img src="' . BASE_URL . '/assets/img/avatars/1.png" alt class="rounded-circle" />
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <h6 class="small mb-0">Congratulation Lettie 🎉</h6>
                              <small class="mb-1 d-block text-body">Won the monthly best seller gold badge</small>
                              <small class="text-muted">1h ago</small>
                            </div>
                            <div class="flex-shrink-0 dropdown-notifications-actions">
                              <a href="javascript:void(0)" class="dropdown-notifications-read"
                                ><span class="badge badge-dot"></span
                              ></a>
                              <a href="javascript:void(0)" class="dropdown-notifications-archive"
                                ><span class="bx bx-x"></span
                              ></a>
                            </div>
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-action dropdown-notifications-item">
                          <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                              <div class="avatar">
                                <span class="avatar-initial rounded-circle bg-label-danger">CF</span>
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <h6 class="small mb-0">Charles Franklin</h6>
                              <small class="mb-1 d-block text-body">Accepted your connection</small>
                              <small class="text-muted">12hr ago</small>
                            </div>
                            <div class="flex-shrink-0 dropdown-notifications-actions">
                              <a href="javascript:void(0)" class="dropdown-notifications-read"
                                ><span class="badge badge-dot"></span
                              ></a>
                              <a href="javascript:void(0)" class="dropdown-notifications-archive"
                                ><span class="bx bx-x"></span
                              ></a>
                            </div>
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                          <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                              <div class="avatar">
                                <img src="' . BASE_URL . '/assets/img/avatars/2.png" alt class="rounded-circle" />
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <h6 class="small mb-0">New Message ✉️</h6>
                              <small class="mb-1 d-block text-body">You have new message from Natalie</small>
                              <small class="text-muted">1h ago</small>
                            </div>
                            <div class="flex-shrink-0 dropdown-notifications-actions">
                              <a href="javascript:void(0)" class="dropdown-notifications-read"
                                ><span class="badge badge-dot"></span
                              ></a>
                              <a href="javascript:void(0)" class="dropdown-notifications-archive"
                                ><span class="bx bx-x"></span
                              ></a>
                            </div>
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-action dropdown-notifications-item">
                          <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                              <div class="avatar">
                                <span class="avatar-initial rounded-circle bg-label-success"
                                  ><i class="bx bx-cart"></i
                                ></span>
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <h6 class="small mb-0">Whoo! You have new order 🛒</h6>
                              <small class="mb-1 d-block text-body">ACME Inc. made new order $1,154</small>
                              <small class="text-muted">1 day ago</small>
                            </div>
                            <div class="flex-shrink-0 dropdown-notifications-actions">
                              <a href="javascript:void(0)" class="dropdown-notifications-read"
                                ><span class="badge badge-dot"></span
                              ></a>
                              <a href="javascript:void(0)" class="dropdown-notifications-archive"
                                ><span class="bx bx-x"></span
                              ></a>
                            </div>
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                          <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                              <div class="avatar">
                                <img src="' . BASE_URL . '/assets/img/avatars/9.png" alt class="rounded-circle" />
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <h6 class="small mb-0">Application has been approved 🚀</h6>
                              <small class="mb-1 d-block text-body"
                                >Your ABC project application has been approved.</small
                              >
                              <small class="text-muted">2 days ago</small>
                            </div>
                            <div class="flex-shrink-0 dropdown-notifications-actions">
                              <a href="javascript:void(0)" class="dropdown-notifications-read"
                                ><span class="badge badge-dot"></span
                              ></a>
                              <a href="javascript:void(0)" class="dropdown-notifications-archive"
                                ><span class="bx bx-x"></span
                              ></a>
                            </div>
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                          <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                              <div class="avatar">
                                <span class="avatar-initial rounded-circle bg-label-success"
                                  ><i class="bx bx-pie-chart-alt"></i
                                ></span>
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <h6 class="small mb-0">Monthly report is generated</h6>
                              <small class="mb-1 d-block text-body">July monthly financial report is generated </small>
                              <small class="text-muted">3 days ago</small>
                            </div>
                            <div class="flex-shrink-0 dropdown-notifications-actions">
                              <a href="javascript:void(0)" class="dropdown-notifications-read"
                                ><span class="badge badge-dot"></span
                              ></a>
                              <a href="javascript:void(0)" class="dropdown-notifications-archive"
                                ><span class="bx bx-x"></span
                              ></a>
                            </div>
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                          <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                              <div class="avatar">
                                <img src="' . BASE_URL . '/assets/img/avatars/5.png" alt class="rounded-circle" />
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <h6 class="small mb-0">Send connection request</h6>
                              <small class="mb-1 d-block text-body">Peter sent you connection request</small>
                              <small class="text-muted">4 days ago</small>
                            </div>
                            <div class="flex-shrink-0 dropdown-notifications-actions">
                              <a href="javascript:void(0)" class="dropdown-notifications-read"
                                ><span class="badge badge-dot"></span
                              ></a>
                              <a href="javascript:void(0)" class="dropdown-notifications-archive"
                                ><span class="bx bx-x"></span
                              ></a>
                            </div>
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-action dropdown-notifications-item">
                          <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                              <div class="avatar">
                                <img src="' . BASE_URL . '/assets/img/avatars/6.png" alt class="rounded-circle" />
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <h6 class="small mb-0">New message from Jane</h6>
                              <small class="mb-1 d-block text-body">Your have new message from Jane</small>
                              <small class="text-muted">5 days ago</small>
                            </div>
                            <div class="flex-shrink-0 dropdown-notifications-actions">
                              <a href="javascript:void(0)" class="dropdown-notifications-read"
                                ><span class="badge badge-dot"></span
                              ></a>
                              <a href="javascript:void(0)" class="dropdown-notifications-archive"
                                ><span class="bx bx-x"></span
                              ></a>
                            </div>
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                          <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                              <div class="avatar">
                                <span class="avatar-initial rounded-circle bg-label-warning"
                                  ><i class="bx bx-error"></i
                                ></span>
                              </div>
                            </div>
                            <div class="flex-grow-1">
                              <h6 class="small mb-0">CPU is running high</h6>
                              <small class="mb-1 d-block text-body"
                                >CPU Utilization Percent is currently at 88.63%,</small
                              >
                              <small class="text-muted">5 days ago</small>
                            </div>
                            <div class="flex-shrink-0 dropdown-notifications-actions">
                              <a href="javascript:void(0)" class="dropdown-notifications-read"
                                ><span class="badge badge-dot"></span
                              ></a>
                              <a href="javascript:void(0)" class="dropdown-notifications-archive"
                                ><span class="bx bx-x"></span
                              ></a>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </li>
                    <li class="border-top">
                      <div class="d-grid p-4">
                        <a class="btn btn-primary btn-sm d-flex" href="javascript:void(0);">
                          <small class="align-middle">View all notifications</small>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
                <!--/ Notification -->
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
                            <h6 class="mb-0">John Doe</h6>
                            <small class="text-muted">Admin</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider my-1"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="pages-profile-user.html">
                        <i class="bx bx-user bx-md me-3"></i><span>My Profile</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="pages-account-settings-account.html">
                        <i class="bx bx-cog bx-md me-3"></i><span>Settings</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="pages-account-settings-billing.html">
                        <span class="d-flex align-items-center align-middle">
                          <i class="flex-shrink-0 bx bx-credit-card bx-md me-3"></i
                          ><span class="flex-grow-1 align-middle">Billing Plan</span>
                          <span class="flex-shrink-0 badge rounded-pill bg-danger">4</span>
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider my-1"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="pages-pricing.html">
                        <i class="bx bx-dollar bx-md me-3"></i><span>Pricing</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="pages-faq.html">
                        <i class="bx bx-help-circle bx-md me-3"></i><span>FAQ</span>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider my-1"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="logout.php" target="_blank">
                        <i class="bx bx-power-off bx-md me-3"></i><span>Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>

            <!-- Search Small Screens -->
            <div class="navbar-search-wrapper search-input-wrapper d-none">
              <input
                type="text"
                class="form-control search-input container-xxl border-0"
                placeholder="Search..."
                aria-label="Search..." />
              <i class="bx bx-x bx-md search-toggler cursor-pointer"></i>
            </div>
          </nav>
        ';
  }

  public function footer()
  {
    return '
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
                                    <a href="' . BASE_URL . '" target="_blank" class="footer-link">Agri Invest</a>
                                </div>
                                
                            </div>
                        </div>
                    </footer>
        ';
  }

  public function  head_includes()
  {
    return  '
           <!-- Fonts -->
            <link rel="preconnect" href="https://fonts.googleapis.com" />
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
            <link
              href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
              rel="stylesheet"
            />

            <!-- Icons -->
            <link rel="stylesheet" href="' . BASE_URL . '/assets/vendor/fonts/boxicons.css" />
            <link rel="stylesheet" href="' . BASE_URL . '/assets/vendor/fonts/fontawesome.css" />
            <link rel="stylesheet" href="' . BASE_URL . '/assets/vendor/fonts/flag-icons.css" />

            <!-- Core CSS -->
            <link rel="stylesheet" href="' . BASE_URL . '/assets/vendor/css/rtl/core.css" />
            <link rel="stylesheet" href="' . BASE_URL . '/assets/vendor/css/rtl/theme-default.css" />
            <link rel="stylesheet" href="' . BASE_URL . '/assets/css/demo.css" />

            <!-- Vendors CSS -->
            <link rel="stylesheet" href="' . BASE_URL . '/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
            <link rel="stylesheet" href="' . BASE_URL . '/assets/vendor/libs/typeahead-js/typeahead.css" />
            <link rel="stylesheet" href="' . BASE_URL . '/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
            <link rel="stylesheet" href="' . BASE_URL . '/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
            <link rel="stylesheet" href="' . BASE_URL . '/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
            <link rel="stylesheet" href="' . BASE_URL . '/assets/vendor/libs/select2/select2.css" />
            <link rel="stylesheet" href="' . BASE_URL . '/assets/vendor/libs/@form-validation/form-validation.css" />
            <link rel="stylesheet" href="' . BASE_URL . '/assets/vendor/libs/flatpickr/flatpickr.css" />
            <link rel="stylesheet" href="' . BASE_URL . '/assets/vendor/libs/apex-charts/apex-charts.css" />

            <!-- Helpers -->
            <script src="' . BASE_URL . '/assets/vendor/js/helpers.js"></script>

            <!-- Config -->
            <!-- Template customizer & Theme config files must be included after core stylesheets and helpers.js -->
            <script src="' . BASE_URL . '/assets/js/config.js"></script>

        ';
  }

  public function body_includes()
  {

    return '
          <!-- Core JS -->
          <!-- build:js assets/vendor/js/core.js -->
          <script src="' . BASE_URL . '/assets/vendor/libs/jquery/jquery.js"></script>
          <script src="' . BASE_URL . '/assets/vendor/libs/popper/popper.js"></script>
          <script src="' . BASE_URL . '/assets/vendor/js/bootstrap.js"></script>
          <script src="' . BASE_URL . '/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
          <script src="' . BASE_URL . '/assets/vendor/libs/hammer/hammer.js"></script>
          <script src="' . BASE_URL . '/assets/vendor/libs/i18n/i18n.js"></script>
          <script src="' . BASE_URL . '/assets/vendor/libs/typeahead-js/typeahead.js"></script>
          <script src="' . BASE_URL . '/assets/vendor/js/menu.js"></script>
          <!-- endbuild -->

          <!-- Vendor Libraries -->
          <script src="' . BASE_URL . '/assets/vendor/libs/moment/moment.js"></script>
          <script src="' . BASE_URL . '/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
          <script src="' . BASE_URL . '/assets/vendor/libs/select2/select2.js"></script>
          <script src="' . BASE_URL . '/assets/vendor/libs/@form-validation/popular.js"></script>
          <script src="' . BASE_URL . '/assets/vendor/libs/@form-validation/bootstrap5.js"></script>
          <script src="' . BASE_URL . '/assets/vendor/libs/@form-validation/auto-focus.js"></script>
          <script src="' . BASE_URL . '/assets/vendor/libs/cleavejs/cleave.js"></script>
          <script src="' . BASE_URL . '/assets/vendor/libs/cleavejs/cleave-phone.js"></script>
          <script src="' . BASE_URL . '/assets/vendor/libs/flatpickr/flatpickr.js"></script>
          <script src="' . BASE_URL . '/assets/vendor/libs/apex-charts/apexcharts.js"></script>

          <!-- Page-Specific JS -->    
         
          
          <!-- Main JS -->
          <script src="' . BASE_URL . '/assets/js/main.js"></script>

        ';
  }

  public function side_nav()
  {
    return '
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="dashboard.php" class="app-brand-link">
              <span class="app-brand-logo demo">
               
              </span>
              <span class="app-brand-text demo menu-text fw-bold ms-2">Agri Invest</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
              <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text" data-i18n="Dashboard ">Dashboard</span>
            </li>
            <li class="menu-item">
              <a href="dashboard.php" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-dashboard"></i>
                <div class="text-truncate" data-i18n="Dashbaord">Dashboard</div>
              </a>
            </li>

            <li class="menu-item">
              <a href="banks.php" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-bank"></i>
                <div class="text-truncate" data-i18n="Banks">Banks</div>
              </a>
            </li>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text" data-i18n="Plans ">Plans</span>
            </li>
            <li class="menu-item">
              <a href="new-plans.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-rupee"></i>
                <div class="text-truncate" data-i18n="Plans">Plans</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="new-lottery.php" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-coupon"></i>
                <div class="text-truncate" data-i18n="Lottery">Lottery</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="refer-and-earn.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-plus"></i>
                <div class="text-truncate" data-i18n="Refer">Refer</div>
              </a>
            </li>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text" data-i18n="Transactions ">Transactions</span>
            </li>
            <li class="menu-item">
              <a href="deposits.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-money"></i>
                <div class="text-truncate" data-i18n="Deposits">Deposits</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="withdraw.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-money-withdraw"></i>
                <div class="text-truncate" data-i18n="Withdraw">Withdraw</div>
              </a>
            </li>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text" data-i18n="Winners">Winners</span>
            </li>
            <li class="menu-item">
              <a href="lottery-winner.php" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-coupon"></i>
                <div class="text-truncate" data-i18n="Lottery">Lottery</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="refer-winners.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-plus"></i>
                <div class="text-truncate" data-i18n="Refer">Refer</div>
              </a>
            </li>


          </ul>
        </aside>
        ';
  }
}
