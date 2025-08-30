$(function () {
    var withdraw_table = $("#withdraw_table");
    
  
    if (withdraw_table.length) {
      var dt_responsive = withdraw_table.DataTable({
        ajax: {
          url: "https://vktsr.vip/api/admin/getallwithdraws",
          method: "GET",
          dataSrc: function (json) {
            console.log(json); // Debug the returned JSON data
            return json; // Ensure the response is in the correct format
          },
          error: function (xhr, error, thrown) {
            console.error("Error fetching data: " + error);
          },
        },
        columns: [
          {
            data: "",
          },
          {
            data: "user_id",
          },
          {
            data: "transaction_id",
          },
          {
            data: "bank_account_name",
          },
          {
            data: "amount",
          },
          {
            data: "bank_name",
          },
          {
            data: "bank_account_number",
          },
          {
            data: "ifsc_code",
            
          },
          {
            data: "",
            render: function (data, type, row) {
                // Render the "Mark as Paid" button with primary color
                return `<button class="btn btn-success mark-as-paid-btn" data-id="${row.transaction_id}">Mark as Paid</button>`;
              }
          },{
            data: "",
            render: function (data, type, row) {
                // Render the "Mark as Paid" button with primary color
                return `<button class="btn btn-danger mark-as-failed-btn" data-id="${row.transaction_id}">Mark as Failed</button>`;
              }
          },
          
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
        ],
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
              var data = $.map(columns, function (col) {
                return col.title !== ""
                  ? '<tr data-dt-row="' +
                      col.rowIndex +
                      '" data-dt-column="' +
                      col.columnIndex +
                      '">' +
                      "<td>" +
                      col.title +
                      ":</td><td>" +
                      col.data +
                      "</td></tr>"
                  : "";
              }).join("");
  
              var transactionId = api.row(rowIdx).data().transaction_id;
             
  
              return data
                ? $('<table class="table"/><tbody />')
                    .append(data)
                    
                : false;
            },
          },
        },
      });
    }
  
    setTimeout(() => {
      $(".dataTables_filter .form-control").removeClass("form-control-sm");
      $(".dataTables_length .form-select").removeClass("form-select-sm");
    }, 200);
  });
  
  $(document).on("click", ".mark-as-paid-btn", function () {
    var status =  "success" ;
    var transactionId = $(this).data("id");
  
    // Reference to the current row
    var $row = $(this).closest("tr");
  
    // Access DataTable instance
    var table = $("#withdraw_table").DataTable();
  
    // Get row index from DataTable
    var rowIndex = table.row($row).index();
  
    // Log the row index
    console.log("Row Index:", rowIndex);
  
    // Get the row data
    var rowData = table.row(rowIndex).data();
  
    // Log the row data
    console.log("Row Data:", rowData);
  
    $.ajax({
      url: "https://vktsr.vip/api/admin/verifywithdraw",
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

  $(document).on("click", ".mark-as-failed-btn", function () {
    var status =  "failed" ;
    var transactionId = $(this).data("id");
  
    // Reference to the current row
    var $row = $(this).closest("tr");
  
    // Access DataTable instance
    var table = $("#withdraw_table").DataTable();
  
    // Get row index from DataTable
    var rowIndex = table.row($row).index();
  
    // Log the row index
    console.log("Row Index:", rowIndex);
  
    // Get the row data
    var rowData = table.row(rowIndex).data();
  
    // Log the row data
    console.log("Row Data:", rowData);
  
    $.ajax({
      url: "https://vktsr.vip/api/admin/verifywithdraw",
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
  