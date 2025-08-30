<?php
header('Content-Type: application/json');

// Predefined list of first and last names
$firstNames = ['John', 'Jane', 'Mike', 'Anna', 'Chris', 'Sara', 'David', 'Emily', 'Robert', 'Sophia'];
$lastNames = ['Smith', 'Johnson', 'Brown', 'Williams', 'Jones', 'Miller', 'Davis', 'Garcia', 'Martinez', 'Hernandez'];

// Generate fake data
$data = [];
for ($i = 1; $i <= 10; $i++) {
    $randomFirstName = $firstNames[array_rand($firstNames)];
    $randomLastName = $lastNames[array_rand($lastNames)];
    
    $data[] = [
        'S no' => $i,
        'bank_id' => $i*$i,
        'bank_account_name' => 'Bank_' . $i*$i,
        'user_id' => 'user_'.rand(10000, 99999),
        'name' => $randomFirstName . ' ' . $randomLastName, // Random name
        'utr_number' => 'UTR' . rand(100000, 999999),
        'bank_name' => 'Bank ' . $i,
        'amount' => number_format(rand(1000, 5000), 2),
        'transaction_id' => 'TXN' . rand(100000, 999999),
        'status' => array_rand(['pending', 'success', 'failed']),
        'image' => 'image.jpeg',
    ];
}

echo json_encode($data);
exit;
?>
