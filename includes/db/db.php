<?php 

$dsn = 'mysql:host=localhost; dbname=vktsr';
$user = 'root';
$password = '';


try{
    $pdo = new PDO($dsn, $user, $password);
}catch(PDOException $e){
    echo 'connection error! ' . $e;
}	
// bLgu+c%ME+EGr!lK eng pass

?>
