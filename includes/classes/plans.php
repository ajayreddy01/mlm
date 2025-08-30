<?php
class Plans
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Create a new plan
    public function createPlan($productName, $price, $dailyIncome, $days, $invitationCommission, $rateOfReturn, $purchaseLimit, $level, $rules, $status = 'active')
    {
        try {
            $totalRevenue = $dailyIncome * $days;
            $stmt = $this->pdo->prepare("
                INSERT INTO plans (product_name, price, daily_income, days, total_revenue, invitation_commission, rate_of_return, purchase_limit, level, rules, status) 
                VALUES (:product_name, :price, :daily_income, :days, :total_revenue, :invitation_commission, :rate_of_return, :purchase_limit, :level, :rules, :status)
            ");
            $stmt->execute([
                ':product_name' => $productName,
                ':price' => $price,
                ':daily_income' => $dailyIncome,
                ':days' => $days,
                ':total_revenue' => $totalRevenue,
                ':invitation_commission' => $invitationCommission,
                ':rate_of_return' => $rateOfReturn,
                ':purchase_limit' => $purchaseLimit,
                ':level' => $level,
                ':rules' => $rules,
                ':status' => $status
            ]);

            return ['status' => 'success', 'message' => 'Plan created successfully'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    // Edit an existing plan
    public function editPlan($planId, $productName, $price, $dailyIncome, $days, $invitationCommission, $rateOfReturn, $purchaseLimit, $level, $rules, $status)
    {
        try {
            $totalRevenue = $dailyIncome * $days;
            $stmt = $this->pdo->prepare("
                UPDATE plans 
                SET product_name = :product_name, 
                    price = :price, 
                    daily_income = :daily_income, 
                    days = :days, 
                    total_revenue = :total_revenue, 
                    invitation_commission = :invitation_commission, 
                    rate_of_return = :rate_of_return, 
                    purchase_limit = :purchase_limit, 
                    level = :level, 
                    rules = :rules,
                    status = :status 
                WHERE id = :planId
            ");
            $stmt->execute([
                ':planId' => $planId,
                ':product_name' => $productName,
                ':price' => $price,
                ':daily_income' => $dailyIncome,
                ':days' => $days,
                ':total_revenue' => $totalRevenue,
                ':invitation_commission' => $invitationCommission,
                ':rate_of_return' => $rateOfReturn,
                ':purchase_limit' => $purchaseLimit,
                ':level' => $level,
                ':rules' => $rules,
                ':status' => $status
            ]);

            return ['status' => 'success', 'message' => 'Plan updated successfully'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    // Delete a plan (soft delete by updating status to 'inactive')
    public function deletePlan($planId)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE plans SET status = 'inactive' WHERE id = :planId");
            $stmt->execute([':planId' => $planId]);

            return ['status' => 'success', 'message' => 'Plan deactivated successfully'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    // Get a plan by ID
    public function getPlan($planId)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM plans WHERE id = :planId");
            $stmt->execute([':planId' => $planId]);
            $plan = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($plan) {
                return ['status' => 'success', 'plan' => $plan];
            } else {
                return ['status' => 'error', 'message' => 'Plan not found'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    // Get all active plans
    public function getAllActivePlans()
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM plans WHERE status = 'active'");
            $stmt->execute();
            $plans = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return ['status' => 'success', 'plans' => $plans];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    // Get all plans (regardless of status)
    public function getAllPlans()
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM plans");
            $stmt->execute();
            $plans = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return ['status' => 'success', 'plans' => $plans];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
    // Function to edit the status of a plan
    public function editStatus($planId, $newStatus)
    {
        try {
            // Validate status value
            if (!in_array($newStatus, ['active', 'inactive'])) {
                throw new Exception("Invalid status value.");
            }

            $sql = "UPDATE plans SET status = :status WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':status', $newStatus);
            $stmt->bindParam(':id', $planId, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "Plan status updated successfully.";
            } else {
                return "No changes made to the plan status.";
            }
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
