<?php 

$dsn = 'mysql:host=localhost; dbname=agri_invest_harvest';
$user = 'agri_invest_user';
$password = 'GK%Yb0vW@0tNBVe';


try{
    $pdo = new PDO($dsn, $user, $password);
}catch(PDOException $e){
    echo 'connection error! ' . $e;
}	
// bLgu+c%ME+EGr!lK eng pass

?>
