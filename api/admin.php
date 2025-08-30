<?php
require '../includes/init.php'; // Include the necessary initialization and class files

header('Content-Type: application/json');

// Get the requested action from query parameters
$action = $_GET['action'] ?? '';
try {
    // Define the API actions
    switch ($action) {

        //login
        case 'login':
            $email = checkinput($_POST['email']);
            $pass = checkinput($_POST['password']);

            $adminData = $admin->adminLogin($email, $pass);

            if ($adminData) {
                session_start();
                $_SESSION['admin_id'] = $adminData['id'];
                $_SESSION['admin_email'] = $adminData['email'];

                echo json_encode([
                    'success' => true,
                    'redirect' => BASE_URL . 'admin/dashboard.php'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Invalid email or password'
                ]);
            }
            break;

        //dashboard data
        case 'getTotalSales':
            // Prepare the result array
            $result = [
                'today' => $admin->getTotalSales('today'),
                'this_week' => $admin->getTotalSales('this_week'),
                'this_month' => $admin->getTotalSales('this_month'),
                'all_time' => $admin->getTotalSales('all_time')
            ];
            // Return the result as JSON
            echo json_encode($result);
            break;

        case 'getTotalDeposits':
            // Prepare the result array
            $result = [
                'today' => $admin->getTotalDeposits('today'),
                'this_week' => $admin->getTotalDeposits('this_week'),
                'this_month' => $admin->getTotalDeposits('this_month'),
                'all_time' => $admin->getTotalDeposits('all_time')
            ];
            // Return the result as JSON
            echo json_encode($result);
            break;

        case 'getTotalWithdrawals':
            // Prepare the result array
            $result = [
                'today' => $admin->getTotalWithdrawals('today'),
                'this_week' => $admin->getTotalWithdrawals('this_week'),
                'this_month' => $admin->getTotalWithdrawals('this_month'),
                'all_time' => $admin->getTotalWithdrawals('all_time')
            ];
            // Return the result as JSON
            echo json_encode($result);
            break;

        case 'getNewCustomers':
            // Prepare the result array
            $result = [
                'today' => $admin->getNewCustomers('today'),
                'this_week' => $admin->getNewCustomers('this_week'),
                'this_month' => $admin->getNewCustomers('this_month'),
                'all_time' => $admin->getNewCustomers('all_time')
            ];
            // Return the result as JSON
            echo json_encode($result);
            break;

        case 'getLotterySales':
            // Prepare the result array
            $result = [
                'today' => $admin->getLotterySales('today'),
                'this_week' => $admin->getLotterySales('this_week'),
                'this_month' => $admin->getLotterySales('this_month'),
                'all_time' => $admin->getLotterySales('all_time')
            ];
            // Return the result as JSON
            echo json_encode($result);
            break;

        case 'getLotteryWithdrawals':
            // Prepare the result array
            $result = [
                'today' => $admin->getLotteryWithdrawals('today'),
                'this_week' => $admin->getLotteryWithdrawals('this_week'),
                'this_month' => $admin->getLotteryWithdrawals('this_month'),
                'all_time' => $admin->getLotteryWithdrawals('all_time')
            ];
            // Return the result as JSON
            echo json_encode($result);
            break;

        //plans insert and update
        case 'insertDataPlans':
            $data = [
                'product_name' => $_POST['name'],
                'price' => $_POST['price'],
                'daily_income' => $_POST['daily_income'],
                'days' => $_POST['days'],
                'bonus' => $_POST['bonus'],
                'total_revenue' => $_POST['revnue'],
                'invitation_commission' => $_POST['invitation_commission'],
                'rate_of_return' => $_POST['ror'],
                'purchase_limit' => $_POST['limit'],
                'level' => $_POST['plantype'],
                'rules' => $_POST['desc'],

            ];
            echo json_encode($admin->insertData('plans', $data));
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        case 'updateDataPlans':
            $data = [
                'product_name' => $_POST['name'],
                'price' => $_POST['price'],
                'daily_income' => $_POST['daily_income'],
                'days' => $_POST['days'],
                'bonus' => $_POST['editbonus'],
                'total_revenue' => $_POST['revenue'],
                'invitation_commission' => $_POST['invitation_commission'],
                'rate_of_return' => $_POST['rate_of_return'],
                'purchase_limit' => $_POST['limit'],
                'level' => $_POST['plantype'],
                'rules' => $_POST['desc'],

            ];
            echo json_encode($admin->updateData('plans', $data, $_POST['planId']));
            break;
        case 'updatePlanStatus':
            $id = $_POST['id'];
            $status = $_POST['status'];
            $data = ['status' => $status];
            echo json_encode($admin->updateData('plans', $data, $id));
            //header("Location: " . $_SERVER['HTTP_REFERER']);
            break;

        // insert and update lottery types 
        case 'insertDataLottery':
            $data = [
                'name' => $_POST['name'],
                'ticket' => $_POST['price'],
                'winning' => $_POST['prize'],
                'type' => $_POST['plantype'],
                'description' => $_POST['desc'],
            ];
            echo json_encode($admin->insertData('lottery_types', $data));
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        case 'updateDataLottery':
            $data = [
                'name' => $_POST['editname'],
                'ticket' => $_POST['editprice'],
                'winning' => $_POST['editprize'],
                'type' => $_POST['editplantype'],
                'description' => $_POST['editdesc'],
            ];
            echo json_encode($admin->updateData('lottery_types', $data, $_POST['editid']));
            break;
        case 'updateStatusLottery':
            $id = $_POST['id'];
            $status = $_POST['status'];
            $data = ['status' => $status];
            echo json_encode($admin->updateData('lottery_types', $data, $id));
            //header("Location: " . $_SERVER['HTTP_REFERER']);
            break;

        // insert and update banks
        case 'insertDataBanks':
            $name = checkinput($_POST['name']);
            $nickname = checkinput($_POST['nickname']);
            $upiid = checkinput($_POST['upiid']);
            $limit = checkinput($_POST['limit']);
            $limitpertransaction = checkinput($_POST['limitpertransaction']);
            $image = $_FILES['image'];
            $imageurl = $admin->uploadimage($image);
            $data = [
                'name' => $name,
                'nickname' => $nickname,
                'acc_limit' => $limit,
                'image' => $imageurl,
                'upi_id' => $upiid,
                'status' => 'active',
                'used_limit' => 0,
                'limit_per_transaction' => $limitpertransaction,
            ];
            echo json_encode($admin->insertData('banks', $data));
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;

        case 'updateDataBanks':
            $id = $_POST['bank_id'];
            $name = checkinput($_POST['name']);
            $nickname = checkinput($_POST['nickname']);
            $upiid = checkinput($_POST['upi_id']);
            $limit = checkinput($_POST['acc_limit']);
            $limitpertransaction = checkinput($_POST['limit_per_transaction']);
            if (!empty($_FILES['image']['name'])) {
                $image = $_FILES['image'];
                $imageurl = $admin->uploadimage($image);
            } else {
                $imageurl = $_POST['image_url'];
            }

            $data = [
                'name' => $name,
                'nickname' => $nickname,
                'acc_limit' => $limit,
                'image' => $imageurl,
                'upi_id' => $upiid,
                'status' => 'active',
                'limit_per_transaction' => $limitpertransaction,
            ];
            echo json_encode($admin->updateData('banks', $data, $id));
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        case 'updateBankStatus':

            $id = $_POST['id'];
            $status = $_POST['status'];
            $data = ['status' => $status];

            echo json_encode($admin->updateData('banks', $data, $id));
            //header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;

        // insert and update Schemes
        case 'insertDataSchemes':
            $scheme_name = checkinput($_POST['scheme_name']);
            $number_of_refers = checkinput($_POST['number_of_refers']);
            $winning_prize = checkinput($_POST['winning_prize']);
            $scheme_type = checkinput($_POST['scheme_type']);
            $description = checkinput($_POST['description']);
            $data = [
                'scheme_name' => $scheme_name,
                'number_of_refers' => $number_of_refers,
                'winning_prize' => $winning_prize,
                'scheme_type' => $scheme_type,
                'description' => $description,
                'status' => 'Active',
            ];
            echo json_encode($admin->insertData('schemes', $data));
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;

        case 'updateDataSchemes':
            $id = $_POST['editid'];
            $scheme_name = checkinput($_POST['editscheme_name']);
            $number_of_refers = checkinput($_POST['editnumber_of_refers']);

            $scheme_type = checkinput($_POST['editscheme_type']);
            $description = checkinput($_POST['editdescription']);
            $winning_prize = $_POST['editwinning_prize'];


            $data = [
                'scheme_name' => $scheme_name,
                'number_of_refers' => $number_of_refers,
                'winning_prize' => $winning_prize,
                'scheme_type' => $scheme_type,
                'description' => $description,
            ];
            echo json_encode($admin->updateData('schemes', $data, $id));
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        case 'updateSchemesStatus':

            $id = $_POST['id'];
            $status = $_POST['status'];
            $data = ['status' => $status];

            echo json_encode($admin->updateData('schemes', $data, $id));
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;

        case 'getallplans':
            echo json_encode($admin->selectData('plans'));
            break;

        case 'getallbanks':
            echo json_encode($admin->selectData('banks'));
            break;

        case 'getalllotterys':
            echo json_encode($admin->selectData('lottery_types'));
            break;

        case 'getallschemes':
            echo json_encode($admin->selectData('schemes'));
            break;

        case 'getalldeposits':
            $data = $admin->getalldeposits();
            echo json_encode($data);
            break;

        case 'getallwithdraws':

            $data = $admin->getallwithdraws();
            echo json_encode($data);
            break;

        case 'verifydeposit':
            $data = $_POST['data']; // Expecting a JSON string with the data

            $status = $_POST['status'];
            $userId = $data['userid'];
            echo json_encode($admin->verifyDeposit($data['transaction_id'], $data, $status, $userId));
            //header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;


        case 'verifywithdraw':
            $id = $_POST['transaction_id']; // Expecting a JSON string with the data
            $status = $_POST['status'];
            $data = $_POST['data'];
            echo json_encode($admin->verifyWithdraw($id, $data, $status, $data['user_id']));
            // header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        case 'all':
            $corn->send_daily_referbonus();
            $corn->send_plan_bonus();
            //$corn->lottery_winner_daily();
            // $corn->lottery_winner_weekly();
            exit;
        case 'lottery':

            $corn->lottery_winner_daily();
            // $corn->lottery_winner_weekly();
            exit;
        default:
            echo json_encode(['error' => 'Invalid action error']);
            break;
    }
} catch (PDOException $e) {
    // Handle database errors
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    // Handle general errors
    echo json_encode(['error' => 'General error: ' . $e->getMessage()]);
}
