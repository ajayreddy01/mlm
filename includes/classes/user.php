<?php
class user extends admin
{
    protected $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    function check_invite_code($referralCode)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE referral_code = :referral_code");

        // Bind the referral code parameter
        $stmt->bindParam(':referral_code', $referralCode, PDO::PARAM_STR);

        // Execute the query
        $stmt->execute();

        // Fetch the result
        $exists = $stmt->fetchColumn() > 0;

        if ($exists) {
            return true;
        } else {
            return false;
        }
    }




    function userSignup($name, $mobile, $password, $referralCode = null, $email)
    {
        try {
            // Validate inputs
            if (empty($name) || empty($mobile) || empty($password) || empty($email)) {
                throw new Exception('All fields are required.');
            }

            // Generate unique IDs
            $userId = 'user_' . substr(uniqid(), 0, 10);
            $new_referral_code = substr(uniqid(), 0, 8);

            // Begin transaction
            $this->pdo->beginTransaction();

            // Insert user
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $query = "INSERT INTO users (userid, name, phone_number, password, referral_code, referred_by,email) 
                  VALUES (:userid, :name, :phone, :password, :referral_code, :referred_by,:email)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                ':userid' => $userId,
                ':name' => $name,
                ':phone' => $mobile,
                ':password' => $hashedPassword,
                ':referral_code' => $new_referral_code,
                ':referred_by' => $referralCode,
                ':email' => $email
            ]);

            // Create wallet
            $query = "INSERT INTO wallet (userid, deposit, withdraw, bonus) VALUES (:userid, 0.00, 0.00, 0.00)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([':userid' => $userId]);

            // Update referral count
            if ($referralCode) {
                $query = "UPDATE users SET referral_count_inactive = referral_count_inactive +1 WHERE referral_code = :referral_code";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute([':referral_code' => $referralCode]);
            }

            // Commit transaction
            $this->pdo->commit();

            // Set session variables
            session_start();
            $_SESSION['userid'] = $userId;
            $_SESSION['name'] = $name;
            $_SESSION['vip'] = 1;

            header("Location: " . BASE_URL . "user/index.php");
            exit();
        } catch (Exception $e) {

            error_log('Error: ' . $e->getMessage());
            echo 'Error: ' . $e->getMessage();
        }
    }

    function userLogin($identifier, $password)
    {
        try {
            // Query to check if the user exists based on phone number
            $query = "SELECT userid, name, phone_number, password 
                  FROM users 
                  WHERE phone_number = :identifier 
                  LIMIT 1";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([':identifier' => $identifier]);

            // Fetch user details
            $user = $stmt->fetch(PDO::FETCH_OBJ);

            if ($user) {
                // Debugging Information

                // Trim both password and hash for safety
                $password = trim($password);
                $hash = trim($user->password);

                if (password_verify($password, $hash)) {
                    echo "Password verified successfully.";
                    $_SESSION['userid'] = $user->userid;
                    $_SESSION['userdata'] = $user;

                    $_SESSION['name'] = $user->name;
                    $_SESSION['vip'] = 1;
                    header("Location: " . BASE_URL . "user/index.php");
                    exit();
                } else {
                    echo "Password verification failed.";
                }
            } else {
                echo "User not found.";
            }
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    public function getReferCode($id)
    {
        // Assuming you have a PDO connection in $this->db
        $query = "SELECT referral_code FROM users WHERE userid = :id";

        try {
            $stmt = $this->pdo->prepare($query); // Prepare the SQL statement
            $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Bind the parameter
            $stmt->execute(); // Execute the statement

            // Fetch the referral code
            $result = $stmt->fetch(PDO::FETCH_OBJ);

            return $result->referral_code; // Return the referral code or null if not found
        } catch (PDOException $e) {
            // Handle any errors
            error_log("Error fetching referral code: " . $e->getMessage());
            return null;
        }
    }



    public function updateAddressById($id, $address)
    {
        try {
            $query = "UPDATE users SET address = :address WHERE userid = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':address', $address, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);

            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Address updated successfully.'];
            } else {
                return ['success' => false, 'message' => 'Failed to update address.'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }
    // Reset or update the password for a user by ID
    public function updatePasswordById($id, $newPassword)
    {
        try {
            // Hash the new password
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

            // Prepare the SQL query to update the password
            $query = "UPDATE users SET password = :password WHERE userid = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);

            // Execute the query
            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Password updated successfully.'];
            } else {
                return ['success' => false, 'message' => 'Failed to update password.'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    function updatebankData($name, $accountNumber, $ifsc, $id, $bank_name)
    {
        $sql = "
            INSERT INTO accounts (user_id, bank_account_name, bank_account_number, bank_name, ifsc_code)
            VALUES (:user_id, :bank_account_name, :bank_account_number, :bank_name, :ifsc_code)
            ON DUPLICATE KEY UPDATE
                bank_account_name = VALUES(bank_account_name),
                bank_account_number = VALUES(bank_account_number),
                bank_name = VALUES(bank_name),
                ifsc_code = VALUES(ifsc_code)
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':user_id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':bank_account_name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':bank_account_number', $accountNumber, PDO::PARAM_STR);
        $stmt->bindParam(':bank_name', $bank_name, PDO::PARAM_STR);
        $stmt->bindParam(':ifsc_code', $ifsc, PDO::PARAM_STR);

        $stmt->execute();

    }

    public function resetpassword($token, $id, $newPassword)
    {
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

    public function getplandata($userid)
    {
        $sql = "
            SELECT p.*, pr.product_name,pr.price 
            FROM purchases p
            JOIN plans pr ON p.plan_id = pr.id 
            WHERE p.user_id = :userid ORDER BY p.id DESC;
        ";

        // Prepare the statement
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);

        // Execute the statement
        $stmt->execute();

        // Fetch all results as an associative array
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }

    public function getActivePlanCount($userid)
    {
        $sql = "
        SELECT COUNT(*) as active_plan_count
        FROM purchases p
        JOIN plans pr ON p.plan_id = pr.id 
        WHERE p.user_id = :userid 
          AND p.status = 'active'
          AND NOW() BETWEEN p.purchase_date AND p.expiry_date;
    ";

        // Prepare the statement
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);

        // Execute the statement
        $stmt->execute();

        // Fetch single row
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['active_plan_count'];
    }


    public function getlotterydata($userid)
    {
        $sql = "
            SELECT p.*, pr.name,pr.ticket AS price
            FROM tickets p
            JOIN lottery_types pr ON p.lottery_id = pr.id 
            WHERE p.user_id = :userid ORDER BY p.id DESC;
        ";

        // Prepare the statement
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);

        // Execute the statement
        $stmt->execute();

        // Fetch all results as an associative array
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }

    public function gettransactiondata($userid)
    {

        $sql = "
            SELECT * FROM transactions
            WHERE user_id = :userid;;
        ";

        // Prepare the statement
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);

        // Execute the statement
        $stmt->execute();

        // Fetch all results as an associative array
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getDirectReferrals($userid)
    {


        // SQL query to fetch direct and indirect referrals
        $sql = "SELECT userid, created_at, status, name, phone_number, 'Direct' AS referral_type
            FROM users
            WHERE referred_by = (SELECT referral_code FROM users WHERE userid = :userid)
            UNION
            SELECT u.userid, u.created_at, u.status, u.name, u.phone_number, 'Indirect' AS referral_type
            FROM users u
            JOIN users d ON u.referred_by = d.referral_code
            WHERE d.referred_by = (SELECT referral_code FROM users WHERE userid = :userid);";


        // Prepare the statement
        $stmt = $this->pdo->prepare($sql);

        // Bind the user_id parameter
        $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);

        // Execute the statement
        $stmt->execute();

        // Fetch results
        $referrals = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $referrals;
    }


    // Example usage
}
