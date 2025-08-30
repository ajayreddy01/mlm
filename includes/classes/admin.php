<?php
class admin
{
    protected $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    private function getDateRange($period)
    {
        switch ($period) {
            case 'today':
                return [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')];
            case 'this_week':
                $startOfWeek = date('Y-m-d 00:00:00', strtotime('last Sunday'));
                $endOfWeek = date('Y-m-d 23:59:59', strtotime('next Saturday'));
                return [$startOfWeek, $endOfWeek];
            case 'this_month':
                $startOfMonth = date('Y-m-01 00:00:00');
                $endOfMonth = date('Y-m-t 23:59:59');
                return [$startOfMonth, $endOfMonth];
            case 'all_time':
                return ['1970-01-01 00:00:00', date('Y-m-d 23:59:59')];
            default:
                return [null, null];
        }
    }

    /**
     * Admin Login Function
     *
     * @param string $email Admin's email
     * @param string $password Admin's password
     * @return mixed Returns admin data on success, or false on failure
     */
        function adminLogin($email, $password)
    {
        try {
            // Database connection (use your actual DB credentials)

            // Prepare the query to fetch the admin record by email
            $sql = "SELECT * FROM admin WHERE email = :email";
            $stmt = $this->pdo->prepare($sql);

            // Bind the email parameter
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);

            // Execute the query
            $stmt->execute();

            // Check if the email exists
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin) {
                // Verify the password (use password_verify if passwords are hashed)
                if (password_verify($password, $admin['password'])) {
                    session_start();

                    // Set session variables
                    $_SESSION['admin_id'] = $admin['id'];
                    header("Location:" . BASE_URL . "./admin/dashboard.php");
                } else {
                    // Incorrect password
                    return 'Invalid email or password.';
                }
            } else {
                // No admin found with the provided email
                return 'Invalid email or password.';
            }
        } catch (PDOException $e) {
            // Handle any database connection errors
            echo "Error: " . $e->getMessage();
            return false;
        }
    }



    public function selecallplans()
    {
        $sql = "SELECT * FROM `plans` WHERE status = `active` ORDER BY price ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
    //stats 
    /**
     * Get total sales for a specific period (today, this week, this month, or all time).
     *
     * @param string $start_date Start date of the period
     * @param string $end_date End date of the period
     * @return float Total sales amount in INR
     */
    function getTotalSales($period)
    {
        $dates = $this->getDateRange($period);
        $start_date = $dates[0];
        $end_date = $dates[1];

        $stmt = $this->pdo->prepare("SELECT SUM(p.price) AS total_sales
                           FROM purchases pu
                           JOIN plans p ON pu.plan_id = p.id
                           WHERE pu.status = 'active'
                           AND DATE(pu.purchase_date) BETWEEN :start_date AND :end_date");

        $stmt->execute(['start_date' => $start_date, 'end_date' => $end_date]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_sales'] ?? 0.00;
    }

    // Example output
    // getTotalSales('2024-12-01', '2024-12-03'); // Returns total sales for the given period

    /**
     * Get total deposits for a specific period (today, this week, this month, or all time).
     *
     * @param string $start_date Start date of the period
     * @param string $end_date End date of the period
     * @return float Total deposit amount in INR
     */
    function getTotalDeposits($period)
    {
        $dates = $this->getDateRange($period);
        $start_date = $dates[0];
        $end_date = $dates[1];

        $stmt = $this->pdo->prepare("SELECT SUM(d.amount) AS total_deposits
                           FROM deposits d
                           WHERE d.status = 'success'
                           AND DATE(d.created_at) BETWEEN :start_date AND :end_date");

        $stmt->execute(['start_date' => $start_date, 'end_date' => $end_date]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_deposits'] ?? 0.00;
    }

    // Example output
    // getTotalDeposits('2024-12-01', '2024-12-03'); // Returns total deposits for the given period

    /**
     * Get total withdrawals for a specific period (today, this week, this month, or all time).
     *
     * @param string $start_date Start date of the period
     * @param string $end_date End date of the period
     * @return float Total withdrawal amount in INR
     */
    function getTotalWithdrawals($period)
    {
        $dates = $this->getDateRange($period);
        $start_date = $dates[0];
        $end_date = $dates[1];

        $stmt = $this->pdo->prepare("SELECT SUM(d.amount) AS total_withdrawals
                           FROM deposits d
                           JOIN accounts a ON d.userid = a.userid
                           WHERE d.status = 'success'
                           AND DATE(d.created_at) BETWEEN :start_date AND :end_date");

        $stmt->execute(['start_date' => $start_date, 'end_date' => $end_date]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_withdrawals'] ?? 0.00;
    }

    // Example output
    // getTotalWithdrawals('2024-12-01', '2024-12-03'); // Returns total withdrawals for the given period

    /**
     * Get the count of new customers (activated users) for a specific period (today, this week, this month, or all time).
     *
     * @param string $start_date Start date of the period
     * @param string $end_date End date of the period
     * @return int Number of new customers
     */
    function getNewCustomers($period)
    {
        $dates = $this->getDateRange($period);
        $start_date = $dates[0];
        $end_date = $dates[1];

        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS new_customers
                           FROM users u
                           WHERE u.status = 1
                           AND DATE(u.created_at) BETWEEN :start_date AND :end_date");

        $stmt->execute(['start_date' => $start_date, 'end_date' => $end_date]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['new_customers'] ?? 0;
    }

    // Example output
    // getNewCustomers('2024-12-01', '2024-12-03'); // Returns the number of new customers for the given period

    /**
     * Get total lottery sales for a specific period (today, this week, this month, or all time).
     *
     * @param string $start_date Start date of the period
     * @param string $end_date End date of the period
     * @return float Total lottery sales in INR
     */
    function getLotterySales($period)
    {
        $dates = $this->getDateRange($period);
        $start_date = $dates[0];
        $end_date = $dates[1];

        $stmt = $this->pdo->prepare("SELECT SUM(lottery_amount) AS lottery_sales
                           FROM tickets t
                           JOIN lotteries l ON t.lottery_id = l.id
                           WHERE DATE(t.created_at) BETWEEN :start_date AND :end_date");

        $stmt->execute(['start_date' => $start_date, 'end_date' => $end_date]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['lottery_sales'] ?? 0.00;
    }

    // Example output
    // getLotterySales('2024-12-01', '2024-12-03'); // Returns total lottery sales for the given period

    /**
     * Get total lottery withdrawals (winnings) for a specific period (today, this week, this month, or all time).
     *
     * @param string $start_date Start date of the period
     * @param string $end_date End date of the period
     * @return float Total lottery withdrawals in INR
     */
    function getLotteryWithdrawals($period)
    {
        $dates = $this->getDateRange($period);
        $start_date = $dates[0];
        $end_date = $dates[1];

        $stmt = $this->pdo->prepare("SELECT SUM(w.prize_amount) AS lottery_withdrawals
                           FROM winners w
                           JOIN lotteries l ON w.lottery_id = l.id
                           WHERE DATE(w.created_at) BETWEEN :start_date AND :end_date");

        $stmt->execute(['start_date' => $start_date, 'end_date' => $end_date]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['lottery_withdrawals'] ?? 0.00;
    }

    // Example output
    // getLotteryWithdrawals('2024-12-01', '2024-12-03'); // Returns total lottery withdrawals for the given period

    /**
     * Insert data into a specified table
     *
     * @param string $table Name of the table to insert into
     * @param array $data Associative array of column names and values
     * @return bool Returns true on success, false on failure
     */
    function insertData($table, $data)
    {
        // Prepare the keys and values for the insert statement
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        try {

            $stmt = $this->pdo->prepare($sql);
            // Execute with the data array
            $stmt->execute(array_values($data));
            return true;
        } catch (PDOException $e) {
            return $e;
        }
    }
    function updateReferralTracking($user_id)
    {



        // SQL query
        $sql = "INSERT INTO referral_tracking (date, user_id, no_of_refers, status)
                    VALUES (CURDATE(), :user_id, 1, 'active')
                    ON DUPLICATE KEY UPDATE 
                        no_of_refers = no_of_refers + 1,
                        status = 'active';";

        // Prepare the statement
        $stmt = $this->pdo->prepare($sql);

        // Bind the user_id parameter
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);

        // Execute the statement
        $stmt->execute();
    }
    /**
     * Update data in a specified table based on the record id
     *
     * @param string $table The name of the table to update
     * @param array $data Associative array of column names and values to update
     * @param int $id The id of the record to update
     * @return bool Returns true on success, false on failure
     */
    function updateData($table, $data, $id)
    {
        // Create the SET part of the SQL query
        $setParts = [];
        foreach ($data as $column => $value) {
            $setParts[] = "$column = :$column";
        }
        $setSql = implode(", ", $setParts);

        // SQL query for updating the record
        $sql = "UPDATE $table SET $setSql WHERE id = :id";

        try {
            // Create PDO instance

            $stmt = $this->pdo->prepare($sql);

            // Bind parameters dynamically for all columns
            foreach ($data as $column => $value) {
                $stmt->bindValue(":$column", $value);
            }

            // Bind the id
            $stmt->bindValue(":id", $id);

            // Execute the query
            $stmt->execute();

            // Return true if update was successful
            return true;
        } catch (PDOException $e) {
            // Handle error and return false
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    function updateDataonuserid($table, $data, $id)
    {
        // Create the SET part of the SQL query
        $setParts = [];
        foreach ($data as $column => $value) {
            $setParts[] = "$column = :$column";
        }
        $setSql = implode(", ", $setParts);

        // SQL query for updating the record
        $sql = "UPDATE $table SET $setSql WHERE userid = :id";



        try {
            // Create PDO instance

            $stmt = $this->pdo->prepare($sql);

            // Bind parameters dynamically for all columns
            foreach ($data as $column => $value) {
                $stmt->bindValue(":$column", $value);
            }

            // Bind the id
            $stmt->bindValue(":id", $id);

            // Execute the query
            $stmt->execute();

            // Return true if update was successful
            return true;
        } catch (PDOException $e) {
            // Handle error and return false
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    /**
     * Update data in a specified table based on the record id
     *
     * @param string $table The name of the table to Select
     * @param int $id The id of the record to Select Not Mandatory if null Selects Whole table and returns The Whole Data
     * @return bool Returns data on success, false on failure
     */
    function selectData($table, $id = null)
    {

        if ($id) {
            // If an id is passed, fetch the row with that id
            $sql = "SELECT * FROM $table WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        } else {
            // If no id is passed, select all rows from the table
            $sql = "SELECT * FROM $table";
            $stmt = $this->pdo->prepare($sql);
        }

        // Execute the statement
        $stmt->execute();

        // Fetch all data if no id was passed, or fetch a single row if id was passed
        return $id ? $stmt->fetch(PDO::FETCH_ASSOC) : $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Selects data from a table based on provided conditions.
     *
     * This function retrieves all rows from a specified table, or a specific row 
     * based on an optional ID. If an ID is passed, it selects the row with that ID. 
     * Otherwise, if custom conditions (column and value) are passed in the `$where` array,
     * it will build a `WHERE` clause based on the provided conditions.
     *
     * @param string $table The name of the table to select data from.
     * @param int|null $id The optional ID to select a specific row. If not provided, it selects all rows.
     * @param array|null $where An optional associative array to build custom `WHERE` conditions, e.g., ['column_name' => 'value'].
     * @return array|false Returns an associative array of results on success, or false on failure.
     * 
     * Usage :
     * $plans = $admin->selectDataWithConditions('plans');
     * $plan = $admin->selectDataWithConditions('plans', 1);
     * $plans = $admin->selectDataWithConditions('plans', null, ['level' => 'Premium']);
     * $plans = $admin->selectDataWithConditions('plans', null, ['price' => 1000, 'level' => 'L1']);
     */
    function selectDataWithConditions($table, $id = null, $where = null)
    {
        try {
            // Base SQL query
            $sql = "SELECT * FROM $table";

            // Adding the WHERE condition if an ID or custom conditions are provided
            if ($id) {
                // If an ID is passed, fetch the row with that ID
                $sql .= " WHERE id = :id";
                $params = [':id' => $id];
            } elseif ($where && is_array($where)) {
                // If custom conditions are passed, build the WHERE clause
                $conditions = [];
                $params = [];
                foreach ($where as $column => $value) {
                    $conditions[] = "$column = :$column";
                    $params[":$column"] = $value;
                }
                $sql .= " WHERE " . implode(" AND ", $conditions);
            } else {
                // If no ID and no custom conditions, select all rows
                $params = [];
            }

            // Prepare and execute the SQL query
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);

            // Return the result based on whether an ID or custom conditions were used
            return $id || $where ? $stmt->fetchAll(PDO::FETCH_ASSOC) : $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false; // Return false in case of any error
        }
    }
    function selectDataWithConditions1($table, $id = null, $where = null)
    {
        try {
            // Base SQL query
            $sql = "SELECT * FROM $table";

            // Adding the WHERE condition if an ID or custom conditions are provided
            if ($id) {
                // If an ID is passed, fetch the row with that ID
                $sql .= " WHERE id = :id";
                $params = [':id' => $id];
            } elseif ($where && is_array($where)) {
                // If custom conditions are passed, build the WHERE clause
                $conditions = [];
                $params = [];
                foreach ($where as $column => $value) {
                    $conditions[] = "$column = :$column";
                    $params[":$column"] = $value;
                }
                $sql .= " WHERE " . implode(" AND ", $conditions);
            } else {
                // If no ID and no custom conditions, select all rows
                $params = [];
            }
            $sql .= " ORDER BY price ASC";

            // Prepare and execute the SQL query
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);

            // Return the result based on whether an ID or custom conditions were used
            return $id || $where ? $stmt->fetchAll(PDO::FETCH_ASSOC) : $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false; // Return false in case of any error
        }
    }

    /**
     * Verifies a deposit transaction and updates the user's wallet balance if successful.
     *
     * @param int $id The transaction ID.
     * @param float $amount The deposit amount.
     * @param string $status The status of the transaction ('success' or 'failed').
     * @param int $userId The ID of the user associated with the transaction.
     * @return bool Returns true if the operation was successful, false otherwise.
     */
    function verifyDeposit($id, $data, $status, $userId): array|bool
    {
        try {
            // Start a database transaction to ensure data integrity
            $this->pdo->beginTransaction();

            // Step 1: Update the transaction status
            $sqlUpdateTransaction = "UPDATE transactions SET status = :status WHERE transaction_id = :id";
            $stmtUpdateTransaction = $this->pdo->prepare($sqlUpdateTransaction);
            $stmtUpdateTransaction->bindParam(':status', $status, PDO::PARAM_STR);
            $stmtUpdateTransaction->bindParam(':id', $id, PDO::PARAM_STR);
            $stmtUpdateTransaction->execute();

            $sqlUpdateTransaction = "UPDATE deposits SET status = :status WHERE id = :id";
            $stmtUpdateTransaction = $this->pdo->prepare($sqlUpdateTransaction);
            $stmtUpdateTransaction->bindParam(':status', $status, PDO::PARAM_STR);
            $stmtUpdateTransaction->bindParam(':id', $data['id'], PDO::PARAM_INT);
            $stmtUpdateTransaction->execute();

            // Step 2: If the transaction is successful, add the amount to the user's wallet
            if ($status === 'success') {
                $sqlUpdateWallet = "UPDATE wallet SET deposit = deposit + :amount WHERE userid = :user_id";
                $stmtUpdateWallet = $this->pdo->prepare($sqlUpdateWallet);
                $stmtUpdateWallet->bindParam(':amount', $data['amount'], PDO::PARAM_STR);
                $stmtUpdateWallet->bindParam(':user_id', $userId, PDO::PARAM_STR);
                $stmtUpdateWallet->execute();

                // Update the bonus column
                $ouserId = $userId;
                $bonusAmount = $data['amount'] * 0.10;

                $sqlUpdateBonus = "UPDATE wallet SET bonus = bonus + :bonus WHERE userid = :user_id";
                $stmtUpdateBonus = $this->pdo->prepare($sqlUpdateBonus);
                $stmtUpdateBonus->bindParam(':bonus', $bonusAmount, PDO::PARAM_STR);
                $stmtUpdateBonus->bindParam(':user_id', $userId, PDO::PARAM_STR);
                $stmtUpdateBonus->execute();

                // Check if user's status is 0
                $sqlCheckStatus = "SELECT status FROM `users` WHERE `userid` = :user_id;";
                $stmtCheckStatus = $this->pdo->prepare($sqlCheckStatus);
                $stmtCheckStatus->bindParam(':user_id', $userId, PDO::PARAM_STR);
                $stmtCheckStatus->execute();
                $status = $stmtCheckStatus->fetch(PDO::FETCH_ASSOC);
                $transaction_id = 'txn_' . substr(uniqid(), 0, 8);
                $stmt = $this->pdo->prepare("
                INSERT INTO transactions (transaction_id, userid, type, amount, from_wallet, status) 
                VALUES (:transaction_id, :userid, 'deposit_bonus', :amount, 'bonus', 'success')");
                $stmt->execute([
                    ':transaction_id' => $transaction_id,
                    ':userid' => $userId,
                    ':amount' => $data['amount'] * 0.1
                ]);

                if ($status && $status['status'] == 0) {
                    // Update status to 1 if it is 0
                    $sqlUpdateStatus = "UPDATE users SET status = 1 WHERE userid = :user_id";
                    $stmtUpdateStatus = $this->pdo->prepare($sqlUpdateStatus);
                    $stmtUpdateStatus->bindParam(':user_id', $userId, PDO::PARAM_STR);
                    $stmtUpdateStatus->execute();
                    if (!empty($status['referred_by'])) {
                        $sq = "UPDATE users SET referral_count = referral_count+1, referral_count_inactive = referral_count_inactive - 1 WHERE referral_code = :data1 RETURNING *";
                        $sts = $this->pdo->prepare($sq);
                        $sts->bindParam(':data1', $status['referred_by'], PDO::PARAM_STR);
                        $sts->execute();
                    }
                    $this->updateReferralTracking($ouserId);
                }
            }

            // Commit the transaction
            $this->pdo->commit();
            $msg = ['message' => 'Status updated successfully.', 'status' => $status, 'ID' => $id, 'Data' => $data];
            return $msg;
        } catch (PDOException $e) {
            // Rollback the transaction in case of an error
            $this->pdo->rollBack();

            return ['message' => 'Status updated Failed.', 'status' => $status, 'ID' => $id, 'Data' => $data, 'error' => $e];
        }
    }


    /**
     * Verifies a withdrawal transaction. Updates the transaction status and, in case of failure,
     * refunds the amount to the user's wallet.
     *
     * @param int $id The transaction ID.
     * @param float $amount The withdrawal amount.
     * @param string $status The status of the transaction ('success' or 'failed').
     * @param int $userId The ID of the user associated with the transaction.
     * @return bool Returns true if the operation was successful, false otherwise.
     */
    function verifyWithdraw($id, $data, $status, $userId): array|bool
    {
        try {
            // Start a database transaction to ensure data integrity
            $this->pdo->beginTransaction();

            // Step 1: Update the transaction status
            $sqlUpdateTransaction = "UPDATE transactions SET status = :status WHERE transaction_id = :id";
            $stmtUpdateTransaction = $this->pdo->prepare($sqlUpdateTransaction);
            $stmtUpdateTransaction->bindParam(':status', $status, PDO::PARAM_STR);
            $stmtUpdateTransaction->bindParam(':id', $id, PDO::PARAM_STR);
            $stmtUpdateTransaction->execute();

            $sqlUpdateTransaction = "UPDATE withdraws SET status = :status WHERE id = :id";
            $stmtUpdateTransaction = $this->pdo->prepare($sqlUpdateTransaction);
            $stmtUpdateTransaction->bindParam(':status', $status, PDO::PARAM_STR);
            $stmtUpdateTransaction->bindParam(':id', $data['id'], PDO::PARAM_INT);
            $stmtUpdateTransaction->execute();

            // Step 2: If the transaction is successful, add the amount to the user's wallet
            if ($status === 'failed') {
                $amount = $data['amount'];
                $amount1 = $amount * 1.112;
                $sqlUpdateWallet = "UPDATE wallet SET withdraw = withdraw + :amount WHERE userid = :user_id";
                $stmtUpdateWallet = $this->pdo->prepare($sqlUpdateWallet);
                $stmtUpdateWallet->bindParam(':amount', $amount1, PDO::PARAM_STR);
                $stmtUpdateWallet->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $stmtUpdateWallet->execute();
            }

            // Commit the transaction
            $this->pdo->commit();
            $msg = ['message' => 'Status updated successfully.', 'status' => $status, 'ID' => $id, 'Data' => $data];
            return $msg;
        } catch (PDOException $e) {
            // Rollback the transaction in case of an error
            $this->pdo->rollBack();
            return ['message' => 'Status updated Failed.', 'status' => $status, 'ID' => $id, 'Data' => $data, 'error' => $e];
        }
    }

    public function uploadImage($file)
    {
        if (is_string($file)) {
            return $file;
        } else {
            $filename = time() . $file['name'];
            $fileTmp = $file['tmp_name'];
            $fileSize = $file['size'];
            $errors = $file['error'];
            $ext = explode('.', $filename);
            $ext = strtolower(end($ext));

            $allowed_extensions = array('jpg', 'png', 'jpeg', 'webp');
            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/uploads/')) {
                mkdir($_SERVER['DOCUMENT_ROOT'] . '/uploads/');
            }

            if (in_array($ext, $allowed_extensions)) {

                if ($errors === 0) {

                    if ($fileSize <= 40971520) {
                        $root = '/uploads/' . $filename;
                        move_uploaded_file($fileTmp, $_SERVER['DOCUMENT_ROOT'] . '/' . $root);
                        return $root;
                    } else {
                        $GLOBALS['imgError'] = "File Size is too large";
                    }
                }
            } else {
                $GLOBALS['imgError'] = "Only alloewd JPG, PNG JPEG extensions";
            }
        }
    }

    public function getalldeposits()
    {

        // SQL Query
        $sql = "
                    SELECT 
                        ROW_NUMBER() OVER (ORDER BY d.id) AS S_No,
                        u.name AS User_Name,
                        b.name AS Bank_Name,
                        d.*
                    FROM 
                        deposits d
                    JOIN 
                        users u ON u.userid = d.userid
                    JOIN 
                        banks b ON b.id = d.bank_id
                    WHERE 
                        d.status = 'pending';
                ";

        // Prepare and execute the query
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        // Fetch all results as an associative array
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getallwithdraws()
    {

        // SQL Query
        $sql = "
           SELECT 
                w.*,
                a.id AS account_id,
                a.bank_account_name,
                a.bank_account_number,
                a.bank_name,
                a.ifsc_code,
                u.name AS user_name
            FROM 
                withdraws w
            JOIN 
                accounts a ON w.accounts_id = a.id
            JOIN 
                users u ON w.user_id = u.userid
            WHERE
                w.status = 'pending';
            ";

        // Prepare and execute the query
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        // Fetch all results as an associative array
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}
