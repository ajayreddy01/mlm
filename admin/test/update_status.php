<?php
header('Content-Type: application/json');

// Mock database connection
// Replace this with actual DB connection
// $conn = new mysqli('host', 'username', 'password', 'database');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transactionId = $_POST['transaction_id'] ?? null;
    $status = $_POST['status'] ?? null;
    $data = $_POST['data'] ?? null;

    if ($transactionId && $status && $data) {
       
        // Update the database
        // Example: $stmt = $conn->prepare("UPDATE transactions SET status = ? WHERE transaction_id = ?");
        // $stmt->bind_param('ss', $status, $transactionId);
        // $stmt->execute();

        echo json_encode(['message' => 'Status updated successfully.', 'status' => $status, 'ID' => $transactionId, 'Data' => $data]);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid data provided.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed.']);
}
?>
