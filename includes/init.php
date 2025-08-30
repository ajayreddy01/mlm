<?php
session_start();
date_default_timezone_set('Asia/Kolkata');

// importing db connection
include 'db/db.php';

// importing modules
// importing modules
include 'classes/template-admin.php';
include 'classes/admin.php';
include 'classes/bank.php';

include 'classes/withdraw.php';
include 'classes/lottery.php';
include 'classes/plans.php';
include 'classes/refer-earn.php';
include 'classes/user.php';
include 'classes/template-user.php';
include 'classes/wallet.php';
include 'classes/corn.php';
function checkinput($data)
{
    $data = htmlspecialchars($data);
    $data = trim($data);
    $data = stripcslashes($data);
    return $data;
}


// calling classes as objects.
global $pdo;

$template_admin = new admin_template($pdo);
$admin = new admin($pdo);
$user = new user($pdo);
$template_user = new user_template($pdo);
$bank = new bank($pdo);
$wallet = new Wallet($pdo);
$refer = new refer($pdo);
$corn = new cornjobs($pdo);
define('BASE_URL', 'http://localhost/vktsr-main/');

?>                                                   


