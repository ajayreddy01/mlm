/**
 * DataTables Advanced (jquery)
 */

"use strict";

$(function () {
  var dt_responsive_table = $(".dt-responsive");
  // Responsive Table
  // --------------------------------------------------------------------

  if (dt_responsive_table.length) {
    var dt_responsive = dt_responsive_table.DataTable({
      ajax: {
        url: "https://vktsr.vip/api/admin/getalldeposits", // URL to your PHP script
        method: "GET", // HTTP method
        dataSrc: function (json) {
          return json; // The response data directly comes in the correct format (array of objects)
        },
        error: function (xhr, error, thrown) {
          console.error("Error fetching data: " + error); // Log any errors to the console
        },
      },
      columns: [
        { data: "" },
        { data: "S_No" },
        { data: "bank_id" },
        { data: "Bank_Name" },
        { data: "userid" },
        { data: "User_Name" },
        { data: "utr_number" },
        { data: "bank_name" },
        { data: "amount" },
        { data: "transaction_id" },
        { data: "status" },
        { data: "image" },
        
      ],
      columnDefs: [
        {
          className: "control",
          orderable: false,
          targets: 0,
          searchable: false,
          render: function (data, type, full, meta) {
            return "";
          },
        },
        {
          // Label
          targets: -2,
          render: function (data, type, full, meta) {
            var $status_number = full["status"];
            var $status = {
              0: { title: "Pending", class: "bg-label-warning" },
              1: { title: "Success", class: " bg-label-success" },
              2: { title: "Failed", class: " bg-label-danger" },
            };
            if (typeof $status[$status_number] === "undefined") {
              return data;
            }
            return (
              '<span class="badge rounded-pill ' +
              $status[$status_number].class +
              '">' +
              $status[$status_number].title +
              "</span>"
            );
          },
        },
      ],
      // scrollX: true,
      destroy: true,
      dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end mt-n6 mt-md-0"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      language: {
        paginate: {
          next: '<i class="bx bx-chevron-right bx-18px"></i>',
          previous: '<i class="bx bx-chevron-left bx-18px"></i>',
        },
      },
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return "Details of " + data["utr_number"];
            },
          }),
          type: "column",
          renderer: function (api, rowIdx, columns) {
            // Generate table rows for the modal
            var data = $.map(columns, function (col) {
              if (col.title !== "" && col.columnIndex !== 11) {
                // Skip the column where image is displayed
                return (
                  '<tr data-dt-row="' +
                  col.rowIndex +
                  '" data-dt-column="' +
                  col.columnIndex +
                  '">' +
                  "<td>" +
                  col.title +
                  ":</td> " +
                  "<td>" +
                  col.data +
                  "</td>" +
                  "</tr>"
                );
              } else if (col.columnIndex === 11) {
                // Image column
                // Render image instead of text for the image column
                return (
                  '<tr data-dt-row="' +
                  col.rowIndex +
                  '" data-dt-column="' +
                  col.columnIndex +
                  '">' +
                  "<td>" +
                  col.title +
                  ":</td> " +
                  "<td>" +
                  "<a href='../" +
                  col.data +
                  "' target='_blank'>" + // Wrap the image in a link to open it in a new tab
                  "<img src='../" +
                  col.data +
                  "' alt='Transaction Image' style='max-width: 100px; height: auto;'>" +
                  "</a>" +
                  "</td>" +
                  "</tr>"
                );
              }
              return ""; // Skip rendering for empty titles
            }).join("");

            // Add buttons for "Success" and "Failed"
            var transactionId = api.row(rowIdx).data().transaction_id; 
            // Fetch transaction ID for the row
            var buttons = `<div class="mt-3 text-center">
                <button type="button" class="btn btn-success me-2 success-btn" data-status ="success" data-id="${transactionId}">Success</button>
                <button type="button" class="btn btn-danger failed-btn" data-status ="failed" data-id="${transactionId}">Failed</button>
              </div>`;

            // Return table with buttons appended
            return data
              ? $('<table class="table"/><tbody />')
                  .append(data)
                  .append(buttons)
              : false;
          },
        },
      },
    });
  }
  $(document).on("click", ".success-btn, .failed-btn", function () {
    var status = $(this).hasClass("success-btn") ? "success" : "failed";
    var transactionId = $(this).data("id");

    // Reference to the current row
    var $row = $(this).closest("tr");

    // Access DataTable instance
    var table = $("#deposit_table").DataTable();

    // Get row index from DataTable
    var rowIndex = table.row($row).index();

    // Log the row index
    console.log("Row Index:", rowIndex);

    // Get the row data
    var rowData = table.row(rowIndex).data();

    // Log the row data
    console.log("Row Data:", rowData);

    $.ajax({
      url: "https://vktsr.vip/api/admin/verifydeposit",
      method: "POST",
      data: {
        transaction_id: transactionId,
        status: status,
        data: rowData,
      },
      success: function (response) {
        var toastMessage = "";
        var toastClass = "";
        var toastIcon = "<i class='bx bx-bell me-2'></i>"; // Default icon

        if (response.message === "Status updated successfully.") {
          toastMessage = "Status updated successfully!";
          toastClass = "bg-success"; // Green success toast
        } else {
          toastMessage = "Failed to update status. Please try again.";
          toastClass = "bg-danger"; // Red error toast
        }

        // Create the toast element
        var toastHtml =
          '<div class="bs-toast toast toast-ex animate__animated my-2 fade ' +
          toastClass +
          ' animate__tada show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000">' +
          '<div class="toast-header">' +
          toastIcon +
          '<div class="me-auto fw-medium">Bootstrap</div>' +
          "<small>Just now</small>" +
          '<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>' +
          "</div>" +
          '<div class="toast-body">' +
          toastMessage +
          "</div>" +
          "</div>";

        // Append the toast to the toast container
        $("#toast-container").html(toastHtml);

        // Use Bootstrap's Toast component to show the toast and remove it after 2 seconds
        var toastElement = $("#toast-container .toast");
        var toast = new bootstrap.Toast(toastElement[0]);
        toast.show();

        // Remove the toast after 2 seconds (if not dismissed)
        setTimeout(function () {
          toastElement.fadeOut(500, function () {
            $(this).remove();
          });
        }, 2000); // 2 seconds

        // After successful update, remove the row from the DataTable
        if (response.message === "Status updated successfully.") {
          table.row(rowIndex).remove().draw(false);
        }
      },
      error: function (xhr, status, error) {
        var errorMessage = "An error occurred while updating the status.";
        var errorToast =
          '<div class="bs-toast toast toast-ex animate__animated my-2 fade bg-danger animate__tada show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000">' +
          '<div class="toast-header">' +
          "<i class='bx bx-bell me-2'></i>" +
          '<div class="me-auto fw-medium">Bootstrap</div>' +
          "<small>Just now</small>" +
          '<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>' +
          "</div>" +
          '<div class="toast-body">' +
          errorMessage +
          "</div>" +
          "</div>";

        // Append the error toast to the toast container
        $("#toast-container").html(errorToast);

        // Use Bootstrap's Toast component to show the toast and remove it after 2 seconds
        var toastElement = $("#toast-container .toast");
        var toast = new bootstrap.Toast(toastElement[0]);
        toast.show();

        // Remove the toast after 2 seconds (if not dismissed)
        setTimeout(function () {
          toastElement.fadeOut(500, function () {
            $(this).remove();
          });
        }, 2000); // 2 seconds
      },
    });
  });

  setTimeout(() => {
    $(".dataTables_filter .form-control").removeClass("form-control-sm");
    $(".dataTables_length .form-select").removeClass("form-select-sm");
  }, 200);
});
