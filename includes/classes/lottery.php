<?php 

class Lottery
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Create a new lottery
    public function createLottery($lotteryTypeId, $date, $period, $lotteryAmount, $returnAmount, $status = 'open')
    {
        $sql = "INSERT INTO lotteries (lottery_type_id, date, period, lottery_amount, return_amount, status)
                VALUES (:lottery_type_id, :date, :period, :lottery_amount, :return_amount, :status)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':lottery_type_id' => $lotteryTypeId,
            ':date' => $date,
            ':period' => $period,
            ':lottery_amount' => $lotteryAmount,
            ':return_amount' => $returnAmount,
            ':status' => $status
        ]);
    }

    // Edit an existing lottery
    public function editLottery($id, $lotteryTypeId, $date, $period, $lotteryAmount, $returnAmount, $status)
    {
        $sql = "UPDATE lotteries
                SET lottery_type_id = :lottery_type_id,
                    date = :date,
                    period = :period,
                    lottery_amount = :lottery_amount,
                    return_amount = :return_amount,
                    status = :status
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':lottery_type_id' => $lotteryTypeId,
            ':date' => $date,
            ':period' => $period,
            ':lottery_amount' => $lotteryAmount,
            ':return_amount' => $returnAmount,
            ':status' => $status
        ]);
    }

    // Delete a lottery
    public function deleteLottery($id)
    {
        $sql = "DELETE FROM lotteries WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // Get all active lotteries
    public function getActiveLotteries()
    {
        $sql = "SELECT * FROM lotteries WHERE status = 'open'";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all lotteries
    public function getAllLotteries()
    {
        $sql = "SELECT * FROM lotteries";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Edit the status of a lottery
    public function editLotteryStatus($id, $status)
    {
        $sql = "UPDATE lotteries SET status = :status WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':status' => $status
        ]);
    }
}

?>