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
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="<?php echo BASE_URL; ?>/assets/"
    data-template="vertical-menu-template-no-customizer" data-style="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Admin Dashboard - Plans</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_URL; ?>/assets/img/favicon/favicon.ico" />
    <?php echo $template_admin->head_includes(); ?>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Side Menu -->
            <?php echo $template_admin->side_nav(); ?>

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <?php echo $template_admin->header(); ?>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="col-lg-12 col-md-6">
                            <div class="mt-4">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalCenter">
                                    Add New Plan
                                </button>

                                <!-- Modal for Add Plan -->
                                <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Add New Plan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form method="post"
                                                action="<?php echo BASE_URL; ?>/api/admin/insertDataPlans" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <div class="row g-6">
                                                        <div class="col mb-6">
                                                            <label for="name" class="form-label">Device Name</label>
                                                            <input type="text" id="name" name="name"
                                                                class="form-control" placeholder="Enter Device Name"
                                                                required />
                                                        </div>
                                                        <div class="col mb-6">
                                                            <label for="price" class="form-label">Product Price</label>
                                                            <input type="number" id="price" name="price"
                                                                class="form-control" placeholder="Enter Product Price"
                                                                required />
                                                        </div>
                                                    </div>
                                                    <div class="row g-6">
                                                        <div class="col mb-0">
                                                            <label for="daily_income" class="form-label">Daily
                                                                Income</label>
                                                            <input type="number" id="daily_income" name="daily_income"
                                                                class="form-control" placeholder="Enter Daily Income"
                                                                required />
                                                        </div>
                                                        <div class="col mb-0">
                                                            <label for="days" class="form-label">Number of Days</label>
                                                            <input type="number" id="days" name="days"
                                                                class="form-control" placeholder="Number of Days"
                                                                required />
                                                        </div>
                                                    </div>
                                                    <div class="row g-6">
                                                        <div class="col mb-0">
                                                            <label for="bonus" class="form-label">Maturity Bonus
                                                                Amount</label>
                                                            <input type="number" id="bonus" name="bonus"
                                                                class="form-control"
                                                                placeholder="Maturity Bonus Amount" />
                                                        </div>
                                                        <div class="col mb-0">
                                                            <label for="revenue" class="form-label">Total
                                                                Revenue</label>
                                                            <input type="number" id="revenue" name="revenue"
                                                                class="form-control" placeholder="Total Revenue" />
                                                        </div>
                                                    </div>
                                                    <div class="row g-6">
                                                        <div class="col mb-0">
                                                            <label for="ror" class="form-label">Rate Of Return</label>
                                                            <input type="number" id="ror" name="ror"
                                                                class="form-control" placeholder="Rate of Return" />
                                                        </div>
                                                        <div class="col mb-0">
                                                            <label for="invitation_commission"
                                                                class="form-label">Invitation Commission</label>
                                                            <input type="number" id="invitation_commission"
                                                                name="invitation_commission" class="form-control"
                                                                placeholder="Invitation Commission" />
                                                        </div>
                                                    </div>
                                                    <div class="row g-6">
                                                        <div class="col mb-0">
                                                            <label for="limit" class="form-label">Plan Limit</label>
                                                            <input type="number" id="limit" name="limit"
                                                                class="form-control" placeholder="Plan Limit" />
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
                                                            <label for="desc" class="form-label">Description</label>
                                                            <textarea name="desc" class="form-control"
                                                                id="desc"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row g-6">
                                                        <div class="col mb-6">
                                                            <label for="name" class="form-label"> Image</label>
                                                            <input type="file" name="image" id="image">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-label-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Plans will render here -->
                        <div id="plans-container" class="row"></div>

                        <!-- Edit Plan Modal -->
                        <div class="modal fade" id="editPlanModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Plan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form id="editPlanForm" method="post">
                                        <input type="hidden" id="planId" name="planId">
                                        <div class="modal-body">
                                            <div class="row g-6">
                                                <div class="col mb-6">
                                                    <label for="productName" class="form-label">Device Name</label>
                                                    <input type="text" id="productName" name="name" class="form-control"
                                                        required />
                                                </div>
                                                <div class="col mb-6">
                                                    <label for="priceEdit" class="form-label">Product Price</label>
                                                    <input type="number" id="priceEdit" name="price"
                                                        class="form-control" required />
                                                </div>
                                            </div>
                                            <div class="row g-6">
                                                <div class="col mb-0">
                                                    <label for="dailyIncome" class="form-label">Daily Income</label>
                                                    <input type="number" id="dailyIncome" name="daily_income"
                                                        class="form-control" required />
                                                </div>
                                                <div class="col mb-0">
                                                    <label for="daysedit" class="form-label">Number of Days</label>
                                                    <input type="number" id="daysedit" name="days" class="form-control"
                                                        required />
                                                </div>
                                            </div>
                                            <div class="row g-6">
                                                <div class="col mb-0">
                                                    <label for="editbonus" class="form-label">Maturity Bonus
                                                        Amount</label>
                                                    <input type="number" id="editbonus" name="bonus"
                                                        class="form-control" />
                                                </div>
                                                <div class="col mb-0">
                                                    <label for="totalRevenue" class="form-label">Total Revenue</label>
                                                    <input type="number" id="totalRevenue" name="revenue"
                                                        class="form-control" />
                                                </div>
                                            </div>
                                            <div class="row g-6">
                                                <div class="col mb-0">
                                                    <label for="rateOfReturn" class="form-label">Rate of Return</label>
                                                    <input type="number" id="rateOfReturn" name="rate_of_return"
                                                        class="form-control" />
                                                </div>
                                                <div class="col mb-0">
                                                    <label for="invitationCommission" class="form-label">Invitation
                                                        Commission</label>
                                                    <input type="number" id="invitationCommission"
                                                        name="invitation_commission" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="row g-6">
                                                <div class="col mb-0">
                                                    <label for="purchaseLimit" class="form-label">Plan Limit</label>
                                                    <input type="number" id="purchaseLimit" name="limit"
                                                        class="form-control" />
                                                </div>
                                                <div class="col mb-0">
                                                    <label for="plantypeEdit" class="form-label">Plan Type</label>
                                                    <select id="plantypeEdit" name="plantype" class="form-select">
                                                        <option value="L1">L1</option>
                                                        <option value="L2">L2</option>
                                                        <option value="Premium">Premium</option>
                                                        <option value="Weekly">Weekly</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row g-6">
                                                <div class="col">
                                                    <label for="editDesc" class="form-label">Description</label>
                                                    <textarea name="desc" id="editDesc" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-label-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Footer -->
                    <?php echo $template_admin->footer(); ?>
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="drag-target"></div>
    </div>

    <?php echo $template_admin->body_includes(); ?>

    <script>
        $(document).ready(function () {
            // Fetch and render plans
            $.ajax({
                url: '<?php echo BASE_URL; ?>/api/admin/getallplans',
                method: 'GET',
                success: function (response) {
                    try {
                        let plans = typeof response === "string" ? JSON.parse(response) : response;
                        let plansHTML = '';
                        plans.forEach(plan => {
                            plansHTML += `
                                <div class="col-lg-4 col-sm-12 col-md-6">
                                    <div class="card mt-3">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"><b>Device Name:</b> ${plan.product_name}</li>
                                            <li class="list-group-item"><b>Product Price:</b> ${plan.price}</li>
                                            <li class="list-group-item"><b>Daily Income:</b> ${plan.daily_income}</li>
                                            <li class="list-group-item"><b>Number of Days:</b> ${plan.days}</li>
                                            <li class="list-group-item"><b>Maturity Bonus:</b> ${plan.bonus}</li>
                                            <li class="list-group-item"><b>Total Revenue:</b> ${plan.total_revenue}</li>
                                            <li class="list-group-item"><b>Invitation Commission:</b> ${plan.invitation_commission}</li>
                                            <li class="list-group-item"><b>Rate of Return:</b> ${plan.rate_of_return}</li>
                                            <li class="list-group-item"><b>Plan Limit:</b> ${plan.purchase_limit}</li>
                                            <li class="list-group-item"><b>Plan Type:</b> ${plan.level}</li>
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
                                                    data-plantype="${plan.level}"
                                                    data-desc="${plan.rules}"
                                                    data-bonus="${plan.bonus}"
                                                    data-bs-toggle="modal" data-bs-target="#editPlanModal">
                                                    Edit
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>`;
                        });
                        $('#plans-container').html(plansHTML);
                    } catch (err) {
                        console.error("Invalid response:", response);
                    }
                }
            });

            // Populate modal for editing
            $(document).on('click', '.edit-plan', function () {
                $('#planId').val($(this).data('id'));
                $('#productName').val($(this).data('product-name'));
                $('#priceEdit').val($(this).data('price'));
                $('#dailyIncome').val($(this).data('daily-income'));
                $('#daysedit').val($(this).data('days'));
                $('#totalRevenue').val($(this).data('total-revenue'));
                $('#invitationCommission').val($(this).data('invitation-commission'));
                $('#rateOfReturn').val($(this).data('rate-of-return'));
                $('#purchaseLimit').val($(this).data('purchase-limit'));
                $('#plantypeEdit').val($(this).data('plantype'));
                $('#editDesc').val($(this).data('desc'));
                $('#editbonus').val($(this).data('bonus'));
            });

            // Save edited plan
            $('#editPlanForm').on('submit', function (e) {
                e.preventDefault();
                const formData = $(this).serialize();
                $.ajax({
                    url: '<?php echo BASE_URL; ?>/api/admin/updateDataPlans',
                    method: 'POST',
                    data: formData,
                    success: function (response) {
                        try {
                            let res = typeof response === "string" ? JSON.parse(response) : response;
                            if (res === true || res.success === true) {
                                location.reload();
                            } else {
                                alert("Failed to update plan.");
                            }
                        } catch (e) {
                            console.error("Invalid response:", response);
                        }
                    }
                });
            });

            // Update status
            $(document).on('click', '.update-status', function () {
                const planId = $(this).data('id');
                const newStatus = $(this).data('status') === 'active' ? 'inactive' : 'active';
                $.ajax({
                    url: '<?php echo BASE_URL; ?>/api/admin/updatePlanStatus',
                    method: 'POST',
                    data: { id: planId, status: newStatus },
                    success: function () {
                        location.reload();
                    }
                });
            });
        });
    </script>
</body>

</html>