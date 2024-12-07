<?php
class BalanceSheetModel
{
    private $connection;
    private $userId;

    public function __construct($connection, $userId)
    {
        $this->connection = $connection;
        $this->userId = $userId;
    }

    public function getIncomesData($startDate, $endDate)
    {
        $stmt = $this->connection->prepare("
            SELECT i.id, i.amount, i.date_of_income, i.income_comment, 
                   c.name AS category_name 
            FROM incomes i 
            JOIN incomes_category_assigned_to_users c ON i.income_category_assigned_to_user_id = c.id 
            WHERE i.user_id = ? AND i.date_of_income BETWEEN ? AND ?
        ");
        $stmt->bind_param("iss", $this->userId, $startDate, $endDate);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getExpensesData($startDate, $endDate)
    {
        $stmt = $this->connection->prepare("
            SELECT e.id, e.amount, e.date_of_expense, e.expense_comment, 
                   c.name AS category_name 
            FROM expenses e 
            JOIN expenses_category_assigned_to_users c ON e.expense_category_assigned_to_user_id = c.id 
            WHERE e.user_id = ? AND e.date_of_expense BETWEEN ? AND ?
        ");
        $stmt->bind_param("iss", $this->userId, $startDate, $endDate);
        $stmt->execute();
        return $stmt->get_result();
    }
}
