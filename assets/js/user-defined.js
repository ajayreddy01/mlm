document.getElementById("copyreferlink").addEventListener("click", function () {
  // Ensure the button has the data-refer_link attribute
  const referLink = this.getAttribute("data-refer_link");

  if (!referLink) {
    console.error("No referral link found in data-refer_link attribute.");
    return;
  }

  // Use the Clipboard API to copy the value
  navigator.clipboard
    .writeText(referLink)
    .then(() => {
      // Show success message
      const status = document.getElementById("copyStatus");
      status.style.display = "inline";
      status.innerText = "Copied to clipboard!";

      setTimeout(() => {
        status.style.display = "none";
      }, 2000); // Hide after 2 seconds
    })
    .catch((err) => {
      console.error("Failed to copy text: ", err);
    });
});

// Function to handle copying the referral link
function copyReferralLink() {
  // Get the button element
  const copyButton = document.getElementById("copyreferlink");

  // Check if the button exists
  if (!copyButton) {
    console.error("Copy button not found.");
    return;
  }

  // Get the referral link from the button's data attribute
  const referLink = copyButton.getAttribute("data-refer-link");

  if (!referLink) {
    console.error("Referral link is missing in the data attribute.");
    return;
  }

  // Use Clipboard API to copy the link
  navigator.clipboard
    .writeText(referLink)
    .then(() => {
      // Show success message
      const status = document.getElementById("copyStatus");
      status.style.display = "inline";
      status.textContent = "Copied to clipboard!";

      // Hide the status message after 2 seconds
      setTimeout(() => {
        status.style.display = "none";
      }, 2000);
    })
    .catch((err) => {
      console.error("Failed to copy text:", err);
    });
}

// Attach event listener to the button
document.addEventListener("DOMContentLoaded", () => {
  const copyButton = document.getElementById("copyreferlink");
  if (copyButton) {
    copyButton.addEventListener("click", copyReferralLink);
  } else {
    console.error("Copy button not found during initialization.");
  }
});


document.getElementById('copyUpiButton').addEventListener('click', function () {
    const upiInput = document.getElementById('upiid'); // Get the input element
    upiInput.select(); // Highlight the text
    upiInput.setSelectionRange(0, 99999); // For mobile compatibility

    // Copy the text to the clipboard
    if (document.execCommand('copy')) {
        // Show success message
        const status = document.getElementById('copyStatus');
        status.style.display = 'inline';
        setTimeout(() => {
            status.style.display = 'none';
        }, 2000); // Hide after 2 seconds
    }
});

function copyToClipboard(button) {
    // Get the referral link from the button's data-refer-link attribute
    const referLink = button.getAttribute('data-refer_link');

    if (!referLink) {
        console.error('No referral link found in the data-refer-link attribute.');
        return;
    }

    // Use the Clipboard API to copy the referral link
    navigator.clipboard.writeText(referLink)
        .then(() => {
            // Display success message
            alert('Referral link copied to clipboard!');
        })
        .catch(err => {
            console.error('Failed to copy text:', err);
        });
}



function buyplan() {
  // Get data attributes from the button
  var button = event.target;
  var planId = button.getAttribute("data-id");
  var price = button.getAttribute("data-price");
  var level = button.getAttribute("data-level");
  var userId = button.getAttribute("data-userid");
  var dailyEarnings = button.getAttribute("data-daily_earnings");
  var commission = button.getAttribute("data-commission");

  // Prepare data to send
  var data = {
      userid: userId,
      plan_id: planId,
      amount: price,
      daily_earnings: dailyEarnings,
      commission: commission
  };
  console.log(data);

  // Display loading effect
  var loadingScreen = document.createElement("div");
  loadingScreen.id = "loading-screen";
  loadingScreen.style.position = "fixed";
  loadingScreen.style.top = "0";
  loadingScreen.style.left = "0";
  loadingScreen.style.width = "100%";
  loadingScreen.style.height = "100%";
  loadingScreen.style.backgroundColor = "rgba(0, 0, 0, 0.5)";
  loadingScreen.style.zIndex = "9999";
  loadingScreen.style.display = "flex";
  loadingScreen.style.justifyContent = "center";
  loadingScreen.style.alignItems = "center";
  loadingScreen.innerHTML = '<div class="spinner-border text-light" role="status"></div>';
  document.body.appendChild(loadingScreen);

  // Make AJAX call to the API
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "https://agriinvestharvest.com/api/user/buyplan", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  // Encode data as URL parameters
  var encodedData = "";
  for (var key in data) {
      if (data.hasOwnProperty(key)) {
          encodedData += encodeURIComponent(key) + "=" + encodeURIComponent(data[key]) + "&";
      }
  }
  encodedData = encodedData.slice(0, -1); // Remove the last "&"

  // Handle the response
  xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
          // Remove loading effect
          var loadingElement = document.getElementById("loading-screen");
          if (loadingElement) {
              document.body.removeChild(loadingElement);
          }

          if (xhr.status === 200) {
              var response = JSON.parse(xhr.responseText);
              if (response === true) {
                  // Show success alert using Bootstrap
                  showAlert('Investment successful!', 'success');
                  // Optionally reload the page or perform another action
                  setTimeout(() => window.location.reload(), 3000);
              } else if (typeof response === 'string' && response === 'Insufficient balance') {
                // Handle specific string responses
                showAlert('Error: Insufficient balance', 'danger');
              }else {
                  // Show error alert using Bootstrap
                  showAlert('Error: Operation failed', 'danger');
              }
          } else {
              // Show error alert for network issues
              showAlert('Error: Network or server issue', 'danger');
          }
      }
  };

  // Send the request with the encoded data
  xhr.send(encodedData);
}


function buylottery() {
    // Get the data attributes from the clicked button
    var button = event.target;
    var lotteryId = button.getAttribute('data-id');
    var userId = button.getAttribute('data-userid');
    var amount = button.getAttribute('data-amount');
    
    // Prepare the data to be sent to the server (for POST)
    var data = new FormData();
    data.append('userid', userId);
    data.append('amount', amount);
    data.append('id', lotteryId); // Sending amount again as per your current PHP case

    // Send the data to the 'buylottery' endpoint using Fetch API
    fetch('https://agriinvestharvest.com/api/user/buylottery', {
      method: 'POST',
      body: data // Send the FormData object
    })
      .then(response => response.json()) // Parse JSON response
      .then(data => {
          // Handle the response from the server
          if (data === true) { // Since the server returns `true`
              showAlert('Ticket purchased successfully!', 'success');
          } else {
              showAlert('Error purchasing ticket. Insufficient Balance.', 'danger');
          }
      })
      .catch(error => {
          // Handle any errors
          console.error('Error:', error);
          showAlert('There was an error processing your request.', 'danger');
      });
}


// Function to display Bootstrap alerts
function showAlert(message, type) {
  const alertContainer = document.getElementById('alert-container');
  
  // Create the alert div
  const alertDiv = document.createElement('div');
  alertDiv.className = `alert alert-${type} alert-dismissible fade show`; // Add Bootstrap classes
  alertDiv.role = 'alert';
  alertDiv.innerHTML = `
      ${message}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  `;
  
  // Append the alert to the container
  alertContainer.appendChild(alertDiv);
  
  // Automatically remove the alert after 5 seconds
  setTimeout(() => {
      alertDiv.classList.remove('show'); // Trigger the fade-out animation
      setTimeout(() => alertDiv.remove(), 150); // Remove the element after animation
  }, 5000);
}



