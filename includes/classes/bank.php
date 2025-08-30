<?php
class bank extends admin
{
    public function selectbank($amount)
    {
        $sql = "SELECT * 
        FROM banks 
        WHERE `limit_per_transaction` > :amount 
        AND `status` = 'active'
        AND `acc_limit` > (used_limit + :amount)
        ORDER BY RAND()
        LIMIT 1;";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':amount' => $amount]);

        // Fetch a random bank entry
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
