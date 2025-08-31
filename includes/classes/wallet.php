<?php

use function PHPSTORM_META\type;

class Wallet extends admin
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Method to deposit amount to the wallet
   public function deposit($userid, $amount, $data)
{
    try {
        $this->pdo->beginTransaction();

        // Generate transaction id
        $transaction_id = 'txn_' . substr(uniqid(), 0, 8);

        // Insert into transactions
        $stmt1 = $this->pdo->prepare("
            INSERT INTO transactions (transaction_id, userid, type, amount, from_wallet, status) 
            VALUES (:transaction_id, :userid, 'deposit', :amount, 'deposit', 'pending')
        ");

        if (!$stmt1->execute([
            ':transaction_id' => $transaction_id,
            ':userid'         => (int) $userid,
            ':amount'         => $amount
        ])) {
            $error = $stmt1->errorInfo();
            throw new Exception("Transaction insert failed: " . $error[2]);
        }

        // Insert into deposits
        $stmt2 = $this->pdo->prepare("
            INSERT INTO deposits 
                (userid, bank_id, utr_number, bank_name, amount, transaction_id, image, status, created_at) 
            VALUES 
                (:userid, :bank_id, :utr_number, :bank_name, :amount, :transaction_id, :image, :status, NOW())
        ");

        $success = $stmt2->execute([
            ':userid'        => (int) $userid,
            ':bank_id'       => (int) $data['bank_id'],
            ':utr_number'    => $data['utr_number'],
            ':bank_name'     => $data['bank_name'],
            ':amount'        => $amount,
            ':transaction_id'=> $transaction_id,
            ':image'         => $data['image'],
            ':status'        => 'pending'
        ]);

        if (!$success) {
            $error = $stmt2->errorInfo();
            throw new Exception("Deposit insert failed: " . $error[2]);
        }

        $this->pdo->commit();

        return ['status' => 'success', 'message' => 'Deposit successful'];

    } catch (Exception $e) {
        $this->pdo->rollBack();
        return ['status' => 'error', 'message' => $e->getMessage()];
    }
}


    /**
     * Helper: Insert row into a table
     */
    private function insertRow($table, $data)
    {
        $columns = array_keys($data);
        $placeholders = array_map(fn($col) => ':' . $col, $columns);

        $sql = "INSERT INTO {$table} (" . implode(',', $columns) . ") 
            VALUES (" . implode(',', $placeholders) . ")";

        $stmt = $this->pdo->prepare($sql);

        foreach ($data as $col => $val) {
            $stmt->bindValue(':' . $col, $val);
        }

        if (!$stmt->execute()) {
            $error = $stmt->errorInfo();
            throw new Exception("Insert into {$table} failed: " . $error[2]);
        }

        return $this->pdo->lastInsertId();
    }



    // Method to withdraw amount from the wallet
    public function withdraw($userid, $amount)
    {
        try {

            // Start transaction
            $this->pdo->beginTransaction();

            // Update wallet withdraw amount
            $stmt = $this->pdo->prepare("
                UPDATE wallet 
                SET withdraw = withdraw - :amount 
                WHERE userid = :userid
            ");
            $stmt->execute([
                ':userid' => $userid,
                ':amount' => $amount
            ]);
            $amount1 = $amount;
            $amount = $amount * 0.9;
            // Insert transaction record for withdraw
            $transaction_id = 'txn_' . substr(uniqid(), 0, 8);
            $stmt = $this->pdo->prepare("
                INSERT INTO transactions (transaction_id, userid, type, amount, from_wallet, status) 
                VALUES (:transaction_id, :userid, 'withdraw', :amount, 'withdraw', 'pending')
            ");
            $stmt->execute([
                ':transaction_id' => $transaction_id,
                ':userid' => $userid,
                ':amount' => $amount
            ]);
            $user_id = $this->selectDataWithConditions('users', null, ['userid' => $userid]);

            $data = $this->selectDataWithConditions('accounts', null, ['userid' => $user_id[0]['id']]);
            $account_id = $data[0]['id'];
            $stmt = $this->pdo->prepare("
                INSERT INTO withdraws (transaction_id, user_id, accounts_id, amount, status) 
                VALUES (:transaction_id, :userid, :accounts_id, :amount,  'pending')
            ");
            $stmt->execute([
                ':transaction_id' => $transaction_id,
                ':userid' => $userid,
                ':accounts_id' => $account_id,
                ':amount' => $amount
            ]);



            // Commit transaction
            $this->pdo->commit();

            return ['status' => 'success', 'message' => 'Withdrawal successful'];
        } catch (Exception $e) {
            // Rollback on error
            $this->pdo->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    // Method to add bonus to the wallet
    public function addBonus($userid, $amount)
    {
        try {
            // Start transaction
            $this->pdo->beginTransaction();

            // Update wallet bonus amount
            $stmt = $this->pdo->prepare("
                UPDATE wallet 
                SET bonus = bonus + :amount 
                WHERE userid = :userid
            ");
            $stmt->execute([
                ':userid' => $userid,
                ':amount' => $amount
            ]);

            // Insert transaction record for bonus
            $transaction_id = 'txn_' . substr(uniqid(), 0, 8);
            ;
            $stmt = $this->pdo->prepare("
                INSERT INTO transactions (transaction_id, userid, type, amount, from_wallet, status) 
                VALUES (:transaction_id, :userid, 'bonus', :amount, 'bonus', 'success')
            ");
            $stmt->execute([
                ':transaction_id' => $transaction_id,
                ':userid' => $userid,
                ':amount' => $amount
            ]);

            // Commit transaction
            $this->pdo->commit();

            return ['status' => 'success', 'message' => 'Bonus added successfully'];
        } catch (Exception $e) {
            // Rollback on error
            $this->pdo->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    // Method to add bonus to the wallet
    public function addwithdraw($userid, $amount)
    {
        try {
            // Start transaction
            $this->pdo->beginTransaction();

            // Update wallet bonus amount
            $stmt = $this->pdo->prepare("
                UPDATE wallet 
                SET withdraw = withdraw + :amount 
                WHERE userid = :userid
            ");
            $stmt->execute([
                ':userid' => $userid,
                ':amount' => $amount
            ]);

            // Insert transaction record for bonus
            $transaction_id = 'txn_' . substr(uniqid(), 0, 8);
            ;
            $stmt = $this->pdo->prepare("
                INSERT INTO transactions (transaction_id, userid, type, amount, from_wallet, status) 
                VALUES (:transaction_id, :userid, 'bonus', :amount, 'withdraw', 'success')
            ");
            $stmt->execute([
                ':transaction_id' => $transaction_id,
                ':userid' => $userid,
                ':amount' => $amount
            ]);

            // Commit transaction
            $this->pdo->commit();

            return ['status' => 'success', 'message' => 'Bonus added successfully'];
        } catch (Exception $e) {
            // Rollback on error
            $this->pdo->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function addwithdrawfunc($userid, $amount, $type)
    {
        try {
            // Start transaction
            $this->pdo->beginTransaction();

            // Update wallet bonus amount
            $stmt = $this->pdo->prepare("
            UPDATE wallet 
            SET withdraw = withdraw + :amount 
            WHERE userid = :userid
        ");
            if (!$stmt->execute([':userid' => $userid, ':amount' => $amount])) {
                throw new Exception("Failed to update wallet for userid: $userid");
            }

            // Insert transaction record for bonus
            $transaction_id = 'txn_' . $userid . substr(uniqid(), 0, 16);
            $stmt1 = $this->pdo->prepare("
            INSERT INTO transactions (transaction_id, userid, type, amount, from_wallet, status) 
            VALUES (:transaction_id, :userid, :type, :amount, 'withdraw', 'success')
        ");
            if (
                !$stmt1->execute([
                    ':transaction_id' => $transaction_id,
                    ':userid' => $userid,
                    ':type' => $type,
                    ':amount' => $amount
                ])
            ) {
                throw new Exception("Failed to insert transaction for userid: $userid");
            }

            // Commit transaction
            $this->pdo->commit();

            return ['status' => 'success', 'message' => 'Bonus added successfully'];
        } catch (Exception $e) {
            // Rollback on error
            $this->pdo->rollBack();

            // Log detailed error
            error_log("Error in addwithdrawfunc: " . $e->getMessage());
            error_log("Stack Trace: " . $e->getTraceAsString());

            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }


    // Method to reduce the bonus from wallet (for bonus withdrawal)
    public function reduceBonus($userid, $amount)
    {
        try {
            // Start transaction
            $this->pdo->beginTransaction();

            // Update wallet bonus amount
            $stmt = $this->pdo->prepare("
                UPDATE wallet 
                SET bonus = bonus - :amount 
                WHERE userid = :userid
            ");
            $stmt->execute([
                ':userid' => $userid,
                ':amount' => $amount
            ]);

            // Insert transaction record for bonus reduction
            $transaction_id = 'txn_' . substr(uniqid(), 0, 8);
            ;
            $stmt = $this->pdo->prepare("
                INSERT INTO transactions (transaction_id, userid, type, amount, from_wallet, status) 
                VALUES (:transaction_id, :userid, 'bonus', :amount, 'bonus', 'success')
            ");
            $stmt->execute([
                ':transaction_id' => $transaction_id,
                ':userid' => $userid,
                ':amount' => $amount
            ]);

            // Commit transaction
            $this->pdo->commit();

            return ['status' => 'success', 'message' => 'Bonus reduced successfully'];
        } catch (Exception $e) {
            // Rollback on error
            $this->pdo->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    // Method to check wallet balance
    public function getWalletBalance($userid)
    {

        $stmt = $this->pdo->prepare("SELECT deposit, withdraw, bonus FROM wallet WHERE userid = :userid");
        $stmt->execute([':userid' => $userid]);
        $wallet = $stmt->fetch(PDO::FETCH_OBJ);
        return $wallet;
    }

    // Method to get transaction history
    public function getTransactionHistory($userid)
    {

        $stmt = $this->pdo->prepare("
                SELECT transaction_id, type, amount, from_wallet, status, created_at 
                FROM transactions 
                WHERE userid = :userid
                ORDER BY created_at DESC
            ");
        $stmt->execute([':userid' => $userid]);
        $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return ['status' => 'success', 'transactions' => $transactions];
    }
    public function getReferrerUserId($userid)
    {
        $sql = "
        SELECT 
            referrer.userid AS referrer_userid
        FROM 
            users AS referrer
        WHERE 
            referrer.referral_code = (
                SELECT 
                    referred.referred_by
                FROM 
                    users AS referred
                WHERE 
                    referred.id = :userid
            );
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['userid' => $userid]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['referrer_userid'];
        } else {
            return "No matching referrer found.";
        }
    }
    public function referandb($userId)
    {

        $sql = "
                SELECT 
                    u1.userid AS direct_referrer,
                    u2.userid AS indirect_referrer
                FROM 
                    users u1
                LEFT JOIN 
                    users u2 ON u1.referred_by = u2.referral_code
                WHERE 
                    u1.userid = :user_id
                ";

        // Execute the query
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $userId]);

        // Fetch and display results
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function referby($userId)
    {
        $sql = "SELECT 
                userid, 
                referred_by 
                FROM 
                    users 
                WHERE 
                    userid = :userid;
                ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':userid' => $userId]);

        // Fetch and display results
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT 
                userid, 
                referred_by 
                FROM 
                    users 
                WHERE 
                    referral_code = :userid;
                ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':userid' => $result['referred_by']]);

        // Fetch and display results
        $result1 = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT 
                userid, 
                referred_by 
                FROM 
                    users 
                WHERE 
                    referral_code = :userid;
                ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':userid' => $result1['referred_by']]);

        // Fetch and display results
        $result2 = $stmt->fetch(PDO::FETCH_ASSOC);

        return [$result1['userid'], $result2['userid']];
    }
    function hasActivePurchase($user_id)
    {
        $query = "SELECT EXISTS (
                    SELECT 1
                    FROM purchases
                    WHERE user_id = :user_id AND status = 'active'
                  ) AS has_active_purchase";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['has_active_purchase'] == 1; // Returns true if valid, otherwise false
    }
    public function buyplan($userid, $planid, $amount, $dailyearning, $commoision)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM purchases WHERE user_id = :userid AND plan_id = :planid AND status = 'active'");
            $stmt->execute(['userid' => $userid, 'planid' => $planid]);
            $activePlansCount = $stmt->fetchColumn();

            if ($activePlansCount >= 2) {
                return "Plan limit exceeded";
            }

            // Fetch wallet data
            $stmt = $this->pdo->prepare("SELECT bonus, deposit, withdraw FROM wallet WHERE userid = :userid");
            $stmt->execute(['userid' => $userid]);
            $userwallet = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$userwallet) {
                throw new Exception("User wallet not found.");
            }

            $totalbal = $userwallet['deposit'] + $userwallet['bonus'] + $userwallet['withdraw'];
            if ($totalbal < $amount) {
                return 'Insufficient balance';
            }

            // Initialize usage amounts
            $depositUsed = $bonusUsed = $withdrawUsed = 0;
            $remainingAmount = $amount;

            // Deduct from deposit wallet
            if ($userwallet['deposit'] >= $remainingAmount) {
                $depositUsed = $remainingAmount;
                $userwallet['deposit'] -= $remainingAmount;
                $remainingAmount = 0;
            } else {
                $depositUsed = $userwallet['deposit'];
                $remainingAmount -= $userwallet['deposit'];
                $userwallet['deposit'] = 0;
            }

            // Deduct from bonus wallet
            if ($remainingAmount > 0 && $userwallet['bonus'] >= $remainingAmount) {
                $bonusUsed = $remainingAmount;
                $userwallet['bonus'] -= $remainingAmount;
                $remainingAmount = 0;
            } else if ($remainingAmount > 0) {
                $bonusUsed = $userwallet['bonus'];
                $remainingAmount -= $userwallet['bonus'];
                $userwallet['bonus'] = 0;
            }

            // Deduct from withdraw wallet
            if ($remainingAmount > 0 && $userwallet['withdraw'] >= $remainingAmount) {
                $withdrawUsed = $remainingAmount;
                $userwallet['withdraw'] -= $remainingAmount;
                $remainingAmount = 0;
            }

            if ($remainingAmount > 0) {
                throw new Exception("Insufficient balance after deduction");
            }

            // Update wallet balances

            $datawallet = [
                'deposit' => $userwallet['deposit'],
                'withdraw' => $userwallet['withdraw'],
                'bonus' => $userwallet['bonus']
            ];
            $this->updateDataonuserid('wallet', $datawallet, $userid);

            // Create a transaction record
            $transaction_id = 'txn_' . substr(uniqid(), 0, 8);
            $datatransactions = [
                'userid' => $userid,
                'transaction_id' => $transaction_id,
                'amount' => $amount,
                'type' => 'plan_buy',
                'status' => 'success',  // Adjusted from $bonusUsed (set appropriate status)
                'notes' => "Deposit used: $depositUsed, Bonus used: $bonusUsed, Withdraw used: $withdrawUsed",
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->insertData('transactions', $datatransactions);
            if ($amount < 5000) {
                $t = '+34 days';
            } else {
                $t = '+52 days';
            }

            // Record the plan purchase
            $dataplans = [
                'user_id' => $userid,
                'plan_id' => $planid,

                'purchase_date' => date('Y-m-d H:i:s'),
                'expiry_date' => date('Y-m-d H:i:s', strtotime($t)),
                'daily_earnings' => $dailyearning,
                'status' => 'active'
            ];
            $data = $this->insertData('purchases', $dataplans);


            $team = $this->referby($userid);
            if ($team[0] != null) {
                if ($this->hasActivePurchase($team[0]) === true) {
                    $this->addwithdrawfunc($team[0], $commoision, 'commission');
                }
            }
            if ($team[1] != null) {
                if ($this->hasActivePurchase($team[1]) === true) {
                    $this->addwithdrawfunc($team[1], $commoision / 2, 'commission');
                }
            }
            return true;
        } catch (Exception $e) {
            //Handle errors
            //error_log($e->getMessage());  // Log error for debugging
            return false;
        }
    }
    function generateString($str1, $str2)
    {
        // Get the current timestamp in milliseconds
        $timestamp = round(num: microtime(true) * 1000);

        // Concatenate the strings and timestamp
        $combined = $str1 . $str2 . $timestamp;

        // Hash the combined string to ensure uniform length
        $hashed = md5($combined);

        // Return the first 13 characters of the hashed string
        return substr($hashed, 0, 13);
    }


    public function buylottery($userid, $amount, $lottery_id)
    {
        $stmt = $this->pdo->prepare("SELECT bonus, deposit, withdraw FROM wallet WHERE userid = :userid");
        $stmt->execute(['userid' => $userid]);
        $userwallet = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalbal = $userwallet['deposit'] + $userwallet['bonus'] + $userwallet['withdraw'];
        if ($totalbal < $amount) {
            throw new Exception("Insufficient balance");
        }

        $depositUsed = $bonusUsed = $withdrawUsed = 0;
        $remainingAmount = $amount;

        // Deduct from deposit wallet
        if ($userwallet['deposit'] >= $remainingAmount) {
            $depositUsed = $remainingAmount;
            $userwallet['deposit'] -= $remainingAmount;
            $remainingAmount = 0;
        } else {
            $depositUsed = $userwallet['deposit'];
            $remainingAmount -= $userwallet['deposit'];
            $userwallet['deposit'] = 0;
        }

        // Deduct from bonus wallet
        if ($remainingAmount > 0 && $userwallet['bonus'] >= $remainingAmount) {
            $bonusUsed = $remainingAmount;
            $userwallet['bonus'] -= $remainingAmount;
            $remainingAmount = 0;
        } else if ($remainingAmount > 0) {
            $bonusUsed = $userwallet['bonus'];
            $remainingAmount -= $userwallet['bonus'];
            $userwallet['bonus'] = 0;
        }

        // Deduct from withdraw wallet
        if ($remainingAmount > 0 && $userwallet['withdraw'] >= $remainingAmount) {
            $withdrawUsed = $remainingAmount;
            $userwallet['withdraw'] -= $remainingAmount;
            $remainingAmount = 0;
        }

        if ($remainingAmount > 0) {
            throw new Exception("Insufficient balance after deduction");
        }

        // Update wallet balances
        $datawallet = [
            'deposit' => $userwallet['deposit'],
            'withdraw' => $userwallet['withdraw'],
            'bonus' => $userwallet['bonus']
        ];
        $this->updateDataonuserid('wallet', $datawallet, $userid);
        $transaction_id = 'txn_' . substr(uniqid(), 0, 8);

        // Add transaction record
        $datatransactions = [
            'userid' => $userid,
            'transaction_id' => $transaction_id,
            'amount' => $amount,
            'type' => 'lottery_buy',
            'status' => 'success',
            'notes' => $withdrawUsed,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->insertData('transactions', $datatransactions);


        $ticket = $this->generateString('user_id', 'lottery_id');
        $lottery_data = [
            'user_id' => $userid,                // User ID participating in the lottery
            'lottery_id' => $lottery_id,         // Lottery ID
            'ticket_number' => $ticket,          // Ticket number issued to the user
            'created_at' => date('Y-m-d H:i:s'), // Current timestamp
            'status' => 'open'                   // Lottery status for the ticket
        ];

        $this->insertData('tickets', $lottery_data);


        return true;
    }
}
