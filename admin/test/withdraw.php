<?php
header('Content-Type: application/json');

// Predefined list of first and last names
$firstNames = ['John', 'Jane', 'Mike', 'Anna', 'Chris', 'Sara', 'David', 'Emily', 'Robert', 'Sophia'];
$lastNames = ['Smith', 'Johnson', 'Brown', 'Williams', 'Jones', 'Miller', 'Davis', 'Garcia', 'Martinez', 'Hernandez'];
$bankNames = ['SBI', 'HDFC', 'Kotak Mahendra','ICICI','Union Bank','Federal Bank'];

// Generate fake data
$data = [];
for ($i = 1; $i <= 10; $i++) {
    $randomFirstName = $firstNames[array_rand($firstNames)];
    $randomLastName = $lastNames[array_rand($lastNames)];
    $bank = $bankNames[array_rand($bankNames)];
    
    $data[] = [
        'user_id' => $i,
        'transaction_id' => 'TXN' . rand(100000, 999999),
        'name' => $randomFirstName . ' ' . $randomLastName, // Random name
        'amount' => number_format(rand(1000, 5000), 2),
        'bank_name' =>  $bank,
        'bank_account_number' =>  rand(111111111, 999999999),
        'ifsc_code' => 'IFSC' . rand(100000, 999999)
        
    ];
}

echo json_encode($data);
exit;
?>
