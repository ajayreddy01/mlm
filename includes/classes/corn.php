<?php
class cornjobs extends Wallet
{
    protected $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    public function send_daily_referbonus()
    {
        $sql = "SELECT * 
                FROM referral_tracking 
                WHERE  date = CURDATE() AND status ='active';";

        // Prepare the statement
        $stmt = $this->pdo->prepare($sql);

        // Bind the user_id parameter
        // Execute the statement
        $stmt->execute();
        $result = $stmt->fetchALL(PDO::FETCH_ASSOC);

        foreach ($result as $row) {
            if ((int)$row['no_of_refers'] >= 3 && (int)$row['no_of_refers'] < 5) {
                $this->addwithdrawfunc($row['user_id'], 300, 'commission');
            } elseif ((int)$row['no_of_refers'] >= 5 && (int)$row['no_of_refers'] < 10) {
                $this->addwithdrawfunc($row['user_id'], 500, 'commission');
            } elseif ((int)$row['no_of_refers'] >= 10 && (int)$row['no_of_refers'] < 10) {
                $this->addwithdrawfunc($row['user_id'],  1000, 'commission');
            } elseif ((int)$row['no_of_refers'] >= 15 && (int)$row['no_of_refers'] < 10) {
                $this->addwithdrawfunc($row['user_id'], 1500, 'commission');
            } elseif ((int)$row['no_of_refers'] >= 20 && (int)$row['no_of_refers'] < 25) {
                $this->addwithdrawfunc($row['user_id'], 2000, 'commission');
            } elseif ((int)$row['no_of_refers'] >= 25 && (int)$row['no_of_refers'] < 40) {
                $this->addwithdrawfunc($row['user_id'], 2000, 'commission');
            } elseif ((int)$row['no_of_refers'] >= 40 && (int)$row['no_of_refers'] < 50) {
                $this->addwithdrawfunc($row['user_id'], 2000, 'commission');
            } elseif ((int)$row['no_of_refers'] == 50) {
                $this->addwithdrawfunc($row['user_id'], 2500, 'commission');
            }
            $sql = "INSERT INTO referral_tracking (date, user_id, no_of_refers, status)
            VALUES (CURDATE(), :user_id, 1, 'inactive')
            ON DUPLICATE KEY UPDATE 
                no_of_refers = no_of_refers ,
                status = 'inactive';";

            // Prepare the statement
            $stmt = $this->pdo->prepare($sql);

            // Bind the user_id parameter
            $stmt->bindParam(':user_id', $row['user_id'], PDO::PARAM_STR);

            // Execute the statement
            $stmt->execute();
        }
    }
    public function send_plan_bonus()
    {
        $sql = "SELECT * 
                FROM purchases
                WHERE status = 'active' 
                AND (expiry_date >= CURDATE());
                ";

        // Prepare the statement
        $stmt = $this->pdo->prepare($sql);

        // Bind the user_id parameter
        // Execute the statement
        $stmt->execute();
        $result = $stmt->fetchALL(PDO::FETCH_ASSOC);

        foreach ($result as $row) {
            $data = $this->addwithdrawfunc($row['user_id'], $row['daily_earnings'], 'daily_earnings');

            $sql = "UPDATE purchases
                    SET total_earned = total_earned + daily_earnings,
                        status = CASE 
                                    WHEN DATE(expiry_date) = CURDATE() THEN 'completed'
                                    ELSE status 
                                END
                    WHERE user_id = :user_id AND status = 'active'
                    AND (DATE(expiry_date) >= CURDATE());
                    ";
            // Prepare the statement
            $stmt = $this->pdo->prepare($sql);

            // Bind the user_id parameter
            $stmt->bindParam(':user_id', $row['user_id'], PDO::PARAM_STR);

            // Execute the statement
            $stmt->execute();
        }
    }
    public function lottery_winner_daily()
    {
            $sql = "WITH random_tickets AS (
                    SELECT t1.id,
                        t1.lottery_id,
                        ROW_NUMBER() OVER (PARTITION BY t1.lottery_id ORDER BY RAND()) AS rn
                    FROM tickets t1
                    JOIN lottery_types l1 ON t1.lottery_id = l1.id
                    WHERE l1.type = 'Daily'
                    AND t1.status = 'open'
                )
                SELECT t.user_id,
                    t.ticket_number,
                    l.winning AS lottery_winning,
                    t.lottery_id,
                    l.name AS lottery_name
                FROM random_tickets r
                JOIN tickets t ON t.id = r.id
                JOIN lottery_types l ON t.lottery_id = l.id
                WHERE r.rn = 1;
                ";

        // Prepare the statement
        $stmt = $this->pdo->prepare($sql);

        // Bind the user_id parameter
        // Execute the statement
        $stmt->execute();
        $result = $stmt->fetchALL(PDO::FETCH_ASSOC);
        print_r($result);
        foreach ($result as $row) {
            $this->addwithdrawfunc($row['user_id'], $row['lottery_winning'], 'lottery_winning');

            // Execute the statement
            $stmt->execute();
            $data = ['lottery_id' => $row['lottery_id'], 'user_id' => $row['user_id'], 'ticket_number' => $row['ticket_number'], 'prize_amount' => $row['lottery_winning']];

            $this->insertData('winners', $data);
        }

        $sql = "UPDATE tickets 
                JOIN lottery_types ON tickets.lottery_id = lottery_types.id
                SET tickets.status = 'closed'
                WHERE lottery_types.type = 'Daily';
                ;";        // Prepare the statement
        $stmt = $this->pdo->prepare($sql);


        // Execute the statement
        $stmt->execute();
    }

    public function lottery_winner_weekly() {
         $sql = "WITH random_tickets AS (
                    SELECT t1.id,
                        t1.lottery_id,
                        ROW_NUMBER() OVER (PARTITION BY t1.lottery_id ORDER BY RAND()) AS rn
                    FROM tickets t1
                    JOIN lottery_types l1 ON t1.lottery_id = l1.id
                    WHERE l1.type = 'Weekly'
                    AND t1.status = 'open'
                )
                SELECT t.user_id,
                    t.ticket_number,
                    l.winning AS lottery_winning,
                    t.lottery_id,
                    l.name AS lottery_name
                FROM random_tickets r
                JOIN tickets t ON t.id = r.id
                JOIN lottery_types l ON t.lottery_id = l.id
                WHERE r.rn = 1;
                ";

        // Prepare the statement
        $stmt = $this->pdo->prepare($sql);

        // Bind the user_id parameter
        // Execute the statement
        $stmt->execute();
        $result = $stmt->fetchALL(PDO::FETCH_ASSOC);
        print_r($result);
        foreach ($result as $row) {
            $this->addwithdrawfunc($row['user_id'], $row['lottery_winning'], 'lottery_winning');

            // Execute the statement
            $stmt->execute();
            $data = ['lottery_id' => $row['lottery_id'], 'user_id' => $row['user_id'], 'ticket_number' => $row['ticket_number'], 'prize_amount' => $row['lottery_winning']];

            $this->insertData('winners', $data);
        }

        $sql = "UPDATE tickets 
                JOIN lottery_types ON tickets.lottery_id = lottery_types.id
                SET tickets.status = 'closed'
                WHERE lottery_types.type = 'Weekly';
                ;";        // Prepare the statement
        $stmt = $this->pdo->prepare($sql);


        // Execute the statement
        $stmt->execute();
    }
}
