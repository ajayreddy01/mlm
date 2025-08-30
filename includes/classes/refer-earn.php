<?php
class refer
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    function getDirectreferals($userid)
    {
        $sql = "SELECT * FROM users WHERE referred_by = :userid";

        // Prepare the statement
        $stmt = $this->pdo->prepare($sql);

        // Bind the user ID parameter
        $stmt->bindParam(':userid', $userid, PDO::PARAM_INT);

        // Execute the statement
        $stmt->execute();

        // Fetch all results as an associative array
        $referrals = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $referrals; // Return the list of direct referrals
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
    function getTodaysReferrals($user_id)
    {

        // SQL query to fetch today's referrals for the given user_id
        $sql = "SELECT no_of_refers 
                FROM referral_tracking 
                WHERE user_id = :user_id AND date = CURDATE();";

        // Prepare the statement
        $stmt = $this->pdo->prepare($sql);

        // Bind the user_id parameter
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);

        // Execute the statement
        $stmt->execute();

        // Fetch the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Return the number of referrals, or 0 if no entry exists
        return $result ? (int)$result['no_of_refers'] : 0;
    }
    function getMonthReferrals($user_id)
    {

        // SQL query to fetch today's referrals for the given user_id
        $sql = "SELECT * FROM users WHERE referred_by = :userid AND YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = MONTH(CURDATE());";

        // Prepare the statement
        $stmt = $this->pdo->prepare($sql);

        // Bind the user ID parameter
        $stmt->bindParam(':userid', $user_id, PDO::PARAM_INT);

        // Execute the statement
        $stmt->execute();

        // Fetch all results as an associative array
        $referrals = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $referrals; // Return the list of direct referrals
    }
}
