<?php
require '../includes/init.php'; // Include the necessary initialization and class files

header('Content-Type: application/json');

// Get the requested action from query parameters
$action = $_GET['action'] ?? '';

try {
    // Define the API actions
    switch ($action) {

        case 'Login':
            break;
        case 'getallplans':
            echo json_encode($admin->selectDataWithConditions1('plans',null, ['status' => 'active']));
            break;
        case 'getalllottery':
            echo json_encode($admin->selectDataWithConditions('lottery_types',null, ['status' => 'active']));
            break;
        case 'getallschemes':
            echo json_encode($admin->selectDataWithConditions('schemes',null, ['status' => 'active']));
            break;
        case 'generateTicket':
            $ticket = $user->generateString('user_id','lottery_id');
            echo json_encode($ticket);
            //header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        case 'getBankaccount':
            
            echo json_encode($bank->selectbank($_POST['amount']));
            //header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        case 'buyplan':
        
            echo json_encode($wallet->buyplan($_POST['userid'],$_POST['plan_id'],$_POST['amount'],$_POST['daily_earnings'], $_POST['commission']));
            //header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        case 'buylottery':
    
            echo json_encode($wallet->buylottery($_POST['userid'],$_POST['amount'],$_POST['id']));
            //header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        
        default:
        echo json_encode(['error' => 'Invalid action']);
        break;
    }
} catch (PDOException $e) {
    // Handle database errors
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    // Handle general errors
    echo json_encode(['error' => 'General error: ' . $e->getMessage()]);
}
