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
                        <div class="col-lg-12 col-md-6">
                            <div class="mt-4">
                                <!-- Button trigger modal -->
                                <button
                                    type="button"
                                    class="btn btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalCenter">
                                    Add New Plan
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalCenterTitle">Add New Plan</h5>
                                                <button
                                                    type="button"
                                                    class="btn-close"
                                                    data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form  method="post" action="<?php echo BASE_URL;?>/api/admin/insertDataPlans">
                                                <div class="modal-body">
                                                    <div class="row g-6">
                                                        <div class="col mb-6">
                                                            <label for="name" class="form-label"> Device Name</label>
                                                            <input
                                                                type="text"
                                                                id="name"
                                                                name="name"
                                                                class="form-control"
                                                                placeholder="Enter Device Name" />
                                                        </div>
                                                        <div class="col mb-6">
                                                            <label for="nickname" class="form-label">Product Price</label>
                                                            <input
                                                                type="number"
                                                                id="price"
                                                                class="form-control"
                                                                name="price"
                                                                placeholder="Enter product Price" />
                                                        </div>
                                                    </div>
                                                    <div class="row g-6">
                                                        <div class="col mb-0">
                                                            <label for="upiid" class="form-label">Daily Income</label>
                                                            <input
                                                                type="number"
                                                                id="daily income"
                                                                name="daily_income"
                                                                class="form-control"
                                                                placeholder="upi@okaxis" />
                                                        </div>
                                                        <div class="col mb-0">
                                                            <label for="limit" class="form-label">Number of Days</label>
                                                            <input
                                                                type="number"
                                                                id="days"
                                                                name="days"
                                                                class="form-control"
                                                                placeholder="Number of Days" />
                                                        </div>

                                                    </div>
                                                    <div class="row g-6">
                                                        <div class="col mb-0">
                                                            <label for="upiid" class="form-label">Maturiy Bonus Amount</label>
                                                            <input
                                                                type="number"
                                                                id="bonus"
                                                                name="bonus"
                                                                class="form-control"
                                                                placeholder="Maturity Bonnus Amount" />
                                                        </div>
                                                        <div class="col mb-0">
                                                            <label for="limit" class="form-label">Total Revenue</label>
                                                            <input
                                                                type="number"
                                                                id="revnue"
                                                                name="revnue"
                                                                class="form-control"
                                                                placeholder="Total Revenue" />
                                                        </div>

                                                    </div>
                                                    <div class="row g-6">
                                                        <div class="col mb-0">
                                                            <label for="upiid" class="form-label">Rate Of Return</label>
                                                            <input
                                                                type="number"
                                                                id="ror"
                                                                name="ror"
                                                                class="form-control"
                                                                placeholder="rate Of return" />
                                                        </div>
                                                        <div class="col mb-0">
                                                            <label for="limit" class="form-label">Invitation Commission </label>
                                                            <input
                                                                type="number"
                                                                id="invitation commission"
                                                                name="invitation_commission"
                                                                class="form-control"
                                                                placeholder="Invitation Commission" />
                                                        </div>

                                                    </div>

                                                    <div class="row g-6">
                                                        <div class="col mb-0">
                                                            <label for="upiid" class="form-label">Plan Limit</label>
                                                            <input
                                                                type="number"
                                                                id="limit"
                                                                name="limit"
                                                                class="form-control"
                                                                placeholder="Plan Limit" />
                                                        </div>
                                                        <div class="col mb-0">
                                                            <label for="limit" class="form-label">Plan Type</label>
                                                            <select id="plantype" name="plantype" class="form-select">
                                                                <option value="L1">L1</option>
                                                                <option value="L2">L2</option>
                                                                <option value="Premium">Premium</option>
                                                                <option value="Weekly">Weekly</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row g-6">
                                                        <div class="col">
                                                            <label for="name" class="form-label"> Description</label>
                                                            <textarea name="desc" class="form-control" id="desc"></textarea>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="plans-container" class="row">

                        </div>


                      
                        <div class="modal fade" id="editPlanModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalCenterTitle">Edit Plan</h5>
                                        <button
                                            type="button"
                                            class="btn-close"
                                            data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form id="editPlanForm" method="post">
                                        <input type="hidden" id="planId" name="planId">
                                        <div class="modal-body">
                                            <div class="row g-6">
                                                <div class="col mb-6">
                                                    <label for="productName" class="form-label">Device Name</label>
                                                    <input
                                                        type="text"
                                                        id="productName"
                                                        name="name"
                                                        class="form-control"
                                                        placeholder="Enter Device Name" />
                                                </div>
                                                <div class="col mb-6">
                                                    <label for="price" class="form-label">Product Price</label>
                                                    <input
                                                        type="number"
                                                        id="price"
                                                        name="price"
                                                        class="form-control"
                                                        placeholder="Enter Product Price" />
                                                </div>
                                            </div>
                                            <div class="row g-6">
                                                <div class="col mb-0">
                                                    <label for="dailyIncome" class="form-label">Daily Income</label>
                                                    <input
                                                        type="number"
                                                        id="dailyIncome"
                                                        name="daily_income"
                                                        class="form-control"
                                                        placeholder="Enter Daily Income" />
                                                </div>
                                                <div class="col mb-0">
                                                    <label for="daysedit" class="form-label">Number of Days</label>
                                                    <input
                                                        type="number"
                                                        id="daysedit"
                                                        name="days"
                                                        class="form-control"
                                                        placeholder="Enter Number of Days" />
                                                </div>
                                            </div>
                                            <div class="row g-6">
                                                <div class="col mb-0">
                                                    <label for="bonus" class="form-label">Maturity Bonus Amount</label>
                                                    <input
                                                        type="number"
                                                        id="editbonus"
                                                        name="editbonus"
                                                        class="form-control"
                                                        placeholder="Enter Maturity Bonus Amount" />
                                                </div>
                                                <div class="col mb-0">
                                                    <label for="totalRevenue" class="form-label">Total Revenue</label>
                                                    <input
                                                        type="number"
                                                        id="totalRevenue"
                                                        name="revenue"
                                                        class="form-control"
                                                        placeholder="Enter Total Revenue" />
                                                </div>
                                            </div>
                                            <div class="row g-6">
                                                <div class="col mb-0">
                                                    <label for="rateOfReturn" class="form-label">Rate of Return</label>
                                                    <input
                                                        type="number"
                                                        id="rateOfReturn"
                                                        name="rate_of_return"
                                                        class="form-control"
                                                        placeholder="Enter Rate of Return" />
                                                </div>
                                                <div class="col mb-0">
                                                    <label for="invitationCommission" class="form-label">Invitation Commission</label>
                                                    <input
                                                        type="number"
                                                        id="invitationCommission"
                                                        name="invitation_commission"
                                                        class="form-control"
                                                        placeholder="Enter Invitation Commission" />
                                                </div>
                                            </div>
                                            <div class="row g-6">
                                                <div class="col mb-0">
                                                    <label for="purchaseLimit" class="form-label">Plan Limit</label>
                                                    <input
                                                        type="number"
                                                        id="purchaseLimit"
                                                        name="limit"
                                                        class="form-control"
                                                        placeholder="Enter Plan Limit" />
                                                </div>
                                                <div class="col mb-0">
                                                    <label for="plantype" class="form-label">Plan Type</label>
                                                    <select id="plantype" name="plantype" class="form-select">
                                                        <option value="L1">L1</option>
                                                        <option value="L2">L2</option>
                                                        <option value="Premium">Premium</option>
                                                        <option value="Weekly">Weekly</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row g-6">
                                                <div class="col">
                                                    <label for="editSesc" class="form-label">Description</label>
                                                    <textarea
                                                        name="desc"
                                                        id="editSesc"
                                                        class="form-control"
                                                        placeholder="Enter Description"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                                                Close
                                            </button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
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

    <script>
        $(document).ready(function() {
            // Fetch and render plans
            $.ajax({
                url: '<?php echo BASE_URL; ?>/api/admin/getallplans',
                method: 'GET',
                success: function(response) {
                    let plansHTML = '';
                    response.forEach(plan => {
                        plansHTML += `
                <div class="col-lg-4 col-sm-12 col-md-6">
                    <div class="card mt-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><span class="label">Device Name:</span> <span class="value">${plan.product_name}</span></li>
                            <li class="list-group-item"><span class="label">Product Price:</span> <span class="value">${plan.price}</span></li>
                            <li class="list-group-item"><span class="label">Daily Income:</span> <span class="value">${plan.daily_income}</span></li>
                            <li class="list-group-item"><span class="label">Number of Days:</span> <span class="value">${plan.days}</span></li>
                            <li class="list-group-item"><span class="label">Maturity Bonus:</span> <span class="value">${plan.bonus}</span></li>
                            <li class="list-group-item"><span class="label">Total Revenue:</span> <span class="value">${plan.total_revenue}</span></li>
                            <li class="list-group-item"><span class="label">Invitation Commission:</span> <span class="value">${plan.invitation_commission}</span></li>
                            <li class="list-group-item"><span class="label">Rate of Return:</span> <span class="value">${plan.rate_of_return}</span></li>
                            <li class="list-group-item"><span class="label">Plan Limit:</span> <span class="value">${plan.purchase_limit}</span></li>
                            <li class="list-group-item"><span class="label">Plan Type:</span> <span class="value">${plan.level}</span></li>
                            <li class="list-group-item">
                                <button class="btn btn-${plan.status === 'active' ? 'warning' : 'success'} update-status" data-id="${plan.id}" data-status="${plan.status}">
                                    ${plan.status === 'active' ? 'Make Inactive' : 'Make Active'}
                                </button>
                                <button class="btn btn-info edit-plan" 
                                    data-id="${plan.id}" 
                                    data-product-name="${plan.product_name}"
                                    data-price="${plan.price}"
                                    data-daily-income="${plan.daily_income}"
                                    data-days="${plan.days}"
                                    data-total-revenue="${plan.total_revenue}"
                                    data-invitation-commission="${plan.invitation_commission}"
                                    data-rate-of-return="${plan.rate_of_return}"
                                    data-purchase-limit="${plan.purchase_limit}"
                                    data-level="${plan.level}"
                                    data-plantype="${plan.level}"
                                    data-desc = "${plan.rules}"
                                    data-bonus = "${plan.bonus}"
                                    data-bs-toggle="modal" data-bs-target="#editPlanModal">
                                    Edit
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>`;
                    });
                    $('#plans-container').html(plansHTML);
                }
            });

            // Populate modal for editing using card data
            $(document).on('click', '.edit-plan', function() {
                $('#planId').val($(this).data('id')); // Plan ID
                $('#productName').val($(this).data('product-name')); // Product Name
                $('#price').val($(this).data('price')); // Price
                $('#dailyIncome').val($(this).data('daily-income')); // Daily Income
                $('#daysedit').val($(this).data('days')); // Number of Days
                $('#totalRevenue').val($(this).data('total-revenue')); // Total Revenue
                $('#invitationCommission').val($(this).data('invitation-commission')); // Invitation Commission
                $('#rateOfReturn').val($(this).data('rate-of-return')); // Rate of Return
                $('#purchaseLimit').val($(this).data('purchase-limit')); // Plan Limit
                $('#level').val($(this).data('level')); // Plan Level
                $('#plantype').val($(this).data('plantype'));
                $('#editSesc').val($(this).data('desc'));
                $('#editbonus').val($(this).data('bonus'));

            });


            // Save edited plan
            $('#editPlanForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission
                const formData = $(this).serialize(); // Serialize form data
                $.ajax({
                    url: '<?php echo BASE_URL; ?>/api/admin/updateDataPlans',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response === true) {
                            // Close the modal
                           

                            // Reload the page
                            location.reload();
                        } 
                    }
                });
            });

            // Update status
            $(document).on('click', '.update-status', function() {
                const planId = $(this).data('id');
                const newStatus = $(this).data('status') === 'active' ? 'inactive' : 'active';
                $.ajax({
                    url: '<?php echo BASE_URL; ?>/api/admin/updatePlanStatus',
                    method: 'POST',
                    data: {
                        id: planId,
                        status: newStatus
                    },
                    success: function() {

                        location.reload(); // Reload to reflect changes
                    }
                });
            });
        });
    </script>
</body>

</html>