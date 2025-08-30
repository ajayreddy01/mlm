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
                                    Add Bank Account
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalCenterTitle">Add Bank Account</h5>
                                                <button
                                                    type="button"
                                                    class="btn-close"
                                                    data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="<?php echo BASE_URL; ?>api/admin/insertDataBanks" method="POST" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <div class="row g-6">
                                                        <div class="col mb-6">
                                                            <label for="name" class="form-label">Name</label>
                                                            <input
                                                                type="text"
                                                                id="name"
                                                                name="name"
                                                                class="form-control"
                                                                placeholder="Enter Name" />
                                                        </div>
                                                        <div class="col mb-6">
                                                            <label for="nickname" class="form-label">Nick Name</label>
                                                            <input
                                                                type="text"
                                                                id="nickname"
                                                                class="form-control"
                                                                name="nickname"
                                                                placeholder="Enter Nikc Name" />
                                                        </div>
                                                    </div>
                                                    <div class="row g-6">

                                                    </div>
                                                    <div class="row g-6">
                                                        <div class="col mb-0">
                                                            <label for="upiid" class="form-label">UPI ID</label>
                                                            <input
                                                                type="email"
                                                                id="upiid"
                                                                name="upiid"
                                                                class="form-control"
                                                                placeholder="upi@okaxis" />
                                                        </div>
                                                        <div class="col mb-0">
                                                            <label for="formFile" class="form-label">UPI Image</label>
                                                            <input class="form-control" type="file" id="image" name="image">
                                                        </div>


                                                    </div>
                                                    <div class="row g-6">
                                                        <div class="col mb-0">
                                                            <label for="limit" class="form-label">Limit Per Day</label>
                                                            <input
                                                                type="number"
                                                                id="limit"
                                                                name="limit"
                                                                class="form-control"
                                                                placeholder="12314" />
                                                        </div>
                                                        <div class="col mb-0">
                                                            <label for="limit" class="form-label">Limit Per Transaction</label>
                                                            <input
                                                                type="number"
                                                                id="limitpertransaction"
                                                                name="limitpertransaction"
                                                                class="form-control"
                                                                placeholder="12314" />
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

                                <div class="modal fade" id="modalCenteredit" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel">Edit Bank Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editBankForm" enctype='multipart/form-data' action="<?php echo BASE_URL;?>/api/admin/updateDataBanks" method="post">
                                                    <input type="hidden" id="bank_id" name="bank_id">
                                                    <input type="hidden" id="image_url" name="image_url">
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Name</label>
                                                        <input type="text" class="form-control" id="name" name="name">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="nickname" class="form-label">Nick Name</label>
                                                        <input type="text" class="form-control" id="nickname" name="nickname">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="upi_id" class="form-label">UPI ID</label>
                                                        <input type="text" class="form-control" id="upi_id" name="upi_id">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="image" class="form-label">Image</label>
                                                        <input type="file" class="form-control" id="image" name="image">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="acc_limit" class="form-label">Limit</label>
                                                        <input type="number" class="form-control" id="acc_limit" name="acc_limit">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="limit_per_transaction" class="form-label">Limit Per Transaction</label>
                                                        <input type="number" class="form-control" id="limit_per_transaction" name="limit_per_transaction">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row" id="cards-banks">


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
            // Function to render banks
            function renderBanks() {
                $.ajax({
                    url: "<?php echo BASE_URL; ?>/api/admin/getallbanks",
                    type: "GET",
                    success: function(response) {
                        const container = $("#cards-banks");
                        container.empty(); // Clear previous content

                        response.forEach(bank => {
                            const statusButton = bank.status === "active" ?
                                `<button type="submit" class="btn btn-warning make-inactive" data-id="${bank.id}">Make Inactive</button>` :
                                `<button type="submit" class="btn btn-success make-active" data-id="${bank.id}">Make Active</button>`;

                            const cardHtml = `
                        <div class="col-lg-4 col-sm-12 col-md-6">
                            <div class="card mt-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Name &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: ${bank.name}</li>
                                    <li class="list-group-item">Nick Name &nbsp; &nbsp; &nbsp;: ${bank.nickname}</li>
                                    <li class="list-group-item">UPI Id &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: ${bank.upi_id}</li>
                                    <li class="list-group-item">Limit &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: ${bank.acc_limit}</li>
                                    <li class="list-group-item">Limit/Transaction: ${bank.limit_per_transaction}</li>
                                    <li class="list-group-item">Image Url: ${bank.image}</li>
                                    <li class="list-group-item">
                                        ${statusButton}
                                        <button type="submit" class="btn btn-info edit-limit" data-id="${bank.id}" data-bs-toggle="modal" data-bs-target="#modalCenteredit">Edit Limit</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    `;
                            container.append(cardHtml);
                        });

                        // Attach event listeners for buttons
                        bindEventListeners();
                    },
                    error: function(error) {
                        console.error("Error fetching bank data:", error);
                    }
                });
            }

            // Function to bind event listeners
            function bindEventListeners() {
                // Change status to active
                $(".make-active").click(function() {
                    const bankId = $(this).data("id");
                    updateStatus(bankId, "active");
                });

                // Change status to inactive
                $(".make-inactive").click(function() {
                    const bankId = $(this).data("id");
                    updateStatus(bankId, "inactive");
                });

                // Open modal for editing
                $(".edit-limit").click(function() {
                    const bankId = $(this).data("id");
                    const bank = $(this).closest(".card").find(".list-group-item");
                    const name = $(bank[0]).text().split(":")[1].trim();
                    const nickname = $(bank[1]).text().split(":")[1].trim();
                    const upiId = $(bank[2]).text().split(":")[1].trim();
                    const limit = $(bank[3]).text().split(":")[1].trim();
                    const limitPerTransaction = $(bank[4]).text().split(":")[1].trim();
                    const image_url = $(bank[5]).text().split(":")[1].trim();

                    $("#modalCenteredit #name").val(name);
                    $("#modalCenteredit #nickname").val(nickname);
                    $("#modalCenteredit #upi_id").val(upiId);
                    $("#modalCenteredit #acc_limit").val(limit);
                    $("#modalCenteredit #limit_per_transaction").val(limitPerTransaction);
                    $("#modalCenteredit #bank_id").val(bankId);
                    $("#modalCenteredit #image_url").val(image_url);
                });
            }

            // Function to update status
            function updateStatus(id, status) {
                $.ajax({
                    url: "<?php echo BASE_URL; ?>/api/admin/updateBankStatus",
                    type: "POST",
                    data: {
                        id,
                        status
                    },
                    success: function() {
                        renderBanks(); // Re-render the updated data
                    },
                    error: function(error) {
                        console.error("Error updating status:", error);
                    }
                });
            }

            // Initial render
            renderBanks();
        });
    </script>
</body>

</html>