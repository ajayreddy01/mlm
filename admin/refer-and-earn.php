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

    <title>Refer And earn Schemes | VKTSR</title>

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
                                    Add New Refer And Earn Scheme
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalCenterTitle">Add New Refer And Earn Scheme</h5>
                                                <button
                                                    type="button"
                                                    class="btn-close"
                                                    data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="<?php echo BASE_URL;?>api/admin/insertDataSchemes" method="post">
                                                <div class="modal-body">
                                                    <div class="row g-6">
                                                        <div class="col mb-6">
                                                            <label for="scheme_name" class="form-label"> Scheme Name</label>
                                                            <input
                                                                type="text"
                                                                id="scheme_name"
                                                                name="scheme_name"
                                                                class="form-control"
                                                                placeholder="Enter Lottery Name" />
                                                        </div>
                                                        <div class="col mb-6">
                                                            <label for="number_of_refers" class="form-label">Number OF Refers</label>
                                                            <input
                                                                type="number"
                                                                id="number_of_refers"
                                                                class="form-control"
                                                                name="number_of_refers"
                                                                placeholder="Enter nukber Of refers" />
                                                        </div>
                                                    </div>

                                                    <div class="row g-6">
                                                        <div class="col mb-0">
                                                            <label for="winning_prize" class="form-label">Winnig Prize</label>
                                                            <input class="form-control" type="text" id="winning_prize" name="winning_prize">
                                                        </div>
                                                        <div class="col mb-0">
                                                            <label for="scheme_type" class="form-label">Scheme Type</label>
                                                            <select id="scheme_type" name="scheme_type" class="form-select">
                                                                <option value="Direct">Direct Referals</option>
                                                                <option value="Indirect">Direct And In Direct Referals (A+ B)</option>
                                                            </select>

                                                        </div>

                                                    </div>
                                                    <div class="row g-6">
                                                        <div class="col mb-6">
                                                            <label for="description" class="form-label"> Description</label>
                                                            <textarea name="description" class="form-control" id="description"></textarea>
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

                            <!-- Modal -->
                            <div class="modal fade" id="editmodalschemes" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalCenterTitle">Edit Refer And Earn Scheme</h5>
                                                <button
                                                    type="button"
                                                    class="btn-close"
                                                    data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="" method="post">
                                                <input type="hidden" name="editid" id="editid">
                                                <div class="modal-body">
                                                    <div class="row g-6">
                                                        <div class="col mb-6">
                                                            <label for="editscheme_name" class="form-label"> Scheme Name</label>
                                                            <input
                                                                type="text"
                                                                id="editscheme_name"
                                                                name="editscheme_name"
                                                                class="form-control"
                                                                placeholder="Enter Lottery Name" />
                                                        </div>
                                                        <div class="col mb-6">
                                                            <label for="editnumber_of_refers" class="form-label">Number OF Refers</label>
                                                            <input
                                                                type="number"
                                                                id="editnumber_of_refers"
                                                                class="form-control"
                                                                name="editnumber_of_refers"
                                                                placeholder="Enter number Of refers" />
                                                        </div>
                                                    </div>

                                                    <div class="row g-6">
                                                        <div class="col mb-0">
                                                            <label for="editwinning_prize" class="form-label">Winnig Prize</label>
                                                            <input class="form-control" type="text" id="editwinning_prize" name="editwinning_prize">
                                                        </div>
                                                        <div class="col mb-0">
                                                            <label for="editscheme_type" class="form-label">Scheme Type</label>
                                                            <select id="editscheme_type" name="editscheme_type" class="form-select">
                                                                <option value="Direct">Direct Referals</option>
                                                                <option value="Indirect">Direct And In Direct Referals (A+ B)</option>
                                                            </select>

                                                        </div>

                                                    </div>
                                                    <div class="row g-6">
                                                        <div class="col mb-6">
                                                            <label for="editdescription" class="form-label"> Description</label>
                                                            <textarea name="editdescription" class="form-control" id="editdescription"></textarea>
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
                           

                            <div id="plans-container" class="row">

                               
                            </div>
                        </div>
                        <!-- / Content -->



                        <div class="content-backdrop fade"></div>
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
                url: '<?php echo BASE_URL; ?>/api/admin/getallschemes',
                method: 'GET',
                success: function(response) {
                    let plansHTML = '';
                    response.forEach(scheme => {
                        plansHTML += `
                        <div class="col-lg-4 col-sm-12 col-md-6">
                            <div class="card mt-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><span class="label">Name:</span> <span class="value">${scheme.scheme_name}</span></li>
                                    <li class="list-group-item"><span class="label">Number Of Refers:</span> <span class="value">${scheme.number_of_refers}</span></li>
                                    <li class="list-group-item"><span class="label">Scheme Type:</span> <span class="value">${scheme.scheme_type}</span></li>
                                    <li class="list-group-item"><span class="label">Prize:</span> <span class="value">${scheme.winning_prize}</span></li>
                                    <li class="list-group-item">
                                        <button class="btn btn-${scheme.status === 'Active' ? 'warning' : 'success'} update-status" 
                                            data-id="${scheme.id}" 
                                            data-status="${scheme.status}">
                                            ${scheme.status === 'Active' ? 'Make Inactive' : 'Make Active'}
                                        </button>
                                        <button class="btn btn-info edit-plan" 
                                            data-id="${scheme.id}" 
                                            data-scheme_name="${scheme.scheme_name}"
                                            data-number_of_refers="${scheme.number_of_refers}"
                                            data-scheme_type="${scheme.scheme_type}"
                                            data-winning_prize="${scheme.winning_prize}"
                                            data-desc="${scheme.description}"
                                            data-bs-toggle="modal" data-bs-target="#editmodalschemes">
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
                $('#editscheme_name').val($(this).data('scheme_name')); // Product Name
                $('#editnumber_of_refers').val($(this).data('number_of_refers')); // Price
                $('#editwinning_prize').val($(this).data('winning_prize')); // Daily Income
                $('#editscheme_type').val($(this).data('scheme_type')); // Number of Days
                $('#editdescription').val($(this).data('desc')); // Total Revenue

            });


            // Save edited plan
            $('#editmodalschemes form').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission
                const formData = $(this).serialize(); // Serialize form data
                $.ajax({
                    url: '<?php echo BASE_URL; ?>/api/admin/updateDataSchemes',
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
                const newStatus = $(this).data('status') === 'Active' ? 'Inactive' : 'Active';
                $.ajax({
                    url: '<?php echo BASE_URL; ?>/api/admin/updateSchemesStatus',
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