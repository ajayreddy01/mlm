<?php 
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to the login page or any other page
header("Location: index.php"); // Replace 'index.php' with your desired redirect page
exit();?>