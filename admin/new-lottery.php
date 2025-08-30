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
                        <div class="mt-4">
                            <!-- Button trigger modal -->
                            <button
                                type="button"
                                class="btn btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#modalCenter">
                                Add New Lottery
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalCenterTitle">Add New Lottery</h5>
                                            <button
                                                type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="<?php echo BASE_URL; ?>api/admin/insertDataLottery" method="post">
                                            <div class="modal-body">
                                                <div class="row g-6">
                                                    <div class="col mb-6">
                                                        <label for="name" class="form-label"> Lottery Name</label>
                                                        <input
                                                            type="text"
                                                            id="name"
                                                            name="name"
                                                            class="form-control"
                                                            placeholder="Enter Lottery Name" />
                                                    </div>
                                                    <div class="col mb-6">
                                                        <label for="nickname" class="form-label">Lottery Ticket Price</label>
                                                        <input
                                                            type="number"
                                                            id="price"
                                                            class="form-control"
                                                            name="price"
                                                            placeholder="Enter Ticket Price" />
                                                    </div>
                                                </div>

                                                <div class="row g-6">
                                                    <div class="col mb-0">
                                                        <label for="upiid" class="form-label">Winnig Prize</label>
                                                        <input
                                                            type="number"
                                                            id="prize"
                                                            name="prize"
                                                            class="form-control"
                                                            placeholder="Prize  Amount" />
                                                    </div>
                                                    <div class="col mb-0">
                                                        <label for="limit" class="form-label">Lottery Type</label>
                                                        <select id="plantype" name="plantype" class="form-select">
                                                            <option value="Daily">Daily</option>
                                                            <option value="Weekly">Weekly</option>
                                                        </select>

                                                    </div>

                                                </div>
                                                <div class="row g-6">
                                                    <div class="col mb-6">
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

                            <!-- Edit Lottery Modal -->
                            <div class="modal fade" id="editLotteryModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalCenterTitle">Edit New Lottery</h5>
                                            <button
                                                type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form  method="post">
                                            <input type="hidden" id="editid" name="editid">
                                            <div class="modal-body">
                                                <div class="row g-6">
                                                    <div class="col mb-6">
                                                        <label for="name" class="form-label"> Lottery Name</label>
                                                        <input
                                                            type="text"
                                                            id="editname"
                                                            name="editname"
                                                            class="form-control"
                                                            placeholder="Enter Lottery Name" />
                                                    </div>
                                                    <div class="col mb-6">
                                                        <label for="nickname" class="form-label">Lottery Ticket Price</label>
                                                        <input
                                                            type="number"
                                                            id="editprice"
                                                            class="form-control"
                                                            name="editprice"
                                                            placeholder="Enter Ticket Price" />
                                                    </div>
                                                </div>

                                                <div class="row g-6">
                                                    <div class="col mb-0">
                                                        <label for="upiid" class="form-label">Winnig Prize</label>
                                                        <input
                                                            type="number"
                                                            id="editprize"
                                                            name="editprize"
                                                            class="form-control"
                                                            placeholder="Prize  Amount" />
                                                    </div>
                                                    <div class="col mb-0">
                                                        <label for="limit" class="form-label">Lottery Type</label>
                                                        <select id="editplantype" name="editplantype" class="form-select">
                                                            <option value="Daily">Daily</option>
                                                            <option value="Weekly">Weekly</option>
                                                        </select>

                                                    </div>

                                                </div>
                                                <div class="row g-6">
                                                    <div class="col mb-6">
                                                        <label for="name" class="form-label"> Description</label>
                                                        <textarea name="editdesc" class="form-control" id="editdesc"></textarea>
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

                        <div id="plans-container" class="row">


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
                url: '<?php echo BASE_URL; ?>/api/admin/getalllotterys',
                method: 'GET',
                success: function(response) {
                    let plansHTML = '';
                    response.forEach(lottery => {
                        plansHTML += `
                        <div class="col-lg-4 col-sm-12 col-md-6">
                            <div class="card mt-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><span class="label">Name:</span> <span class="value">${lottery.name}</span></li>
                                    <li class="list-group-item"><span class="label">Ticket Price:</span> <span class="value">${lottery.ticket}</span></li>
                                    <li class="list-group-item"><span class="label">Winning Amount:</span> <span class="value">${lottery.winning}</span></li>
                                    <li class="list-group-item"><span class="label">Lottery Type:</span> <span class="value">${lottery.type}</span></li>
                                    <li class="list-group-item">
                                        <button class="btn btn-${lottery.status === 'active' ? 'warning' : 'success'} update-status" 
                                            data-id="${lottery.id}" 
                                            data-status="${lottery.status}">
                                            ${lottery.status === 'active' ? 'Make Inactive' : 'Make Active'}
                                        </button>
                                        <button class="btn btn-info edit-plan" 
                                            data-id="${lottery.id}" 
                                            data-name="${lottery.name}"
                                            data-ticket="${lottery.ticket}"
                                            data-winning="${lottery.winning}"
                                            data-type="${lottery.type}"
                                            data-desc="${lottery.description}"
                                            data-bs-toggle="modal" data-bs-target="#editLotteryModal">
                                            Edit
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>`;
                    });
                    $('#plans-container').html(plansHTML);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching lotteries:', error);
                }
            });


            // Populate modal for editing using card data
            $(document).on('click', '.edit-plan', function() {
                $('#editid').val($(this).data('id')); // Plan ID
                $('#editname').val($(this).data('name')); // Product Name
                $('#editprice').val($(this).data('ticket')); // Price
                $('#editprize').val($(this).data('winning')); // Daily Income
                $('#editplantype').val($(this).data('type')); // Number of Days
                $('#editdesc').val($(this).data('desc')); // Total Revenue

            });


            // Save edited plan
            $('#editLotteryModal form').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission
                const formData = $(this).serialize(); // Serialize form data
                $.ajax({
                    url: '<?php echo BASE_URL; ?>/api/admin/updateDataLottery',
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
                    url: '<?php echo BASE_URL; ?>/api/admin/updateStatusLottery',
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