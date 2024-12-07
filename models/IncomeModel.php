<?php

class IncomeModel
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getIncomeCategories($userId)
    {
        $categories = [];
        $stmt = $this->connection->prepare("SELECT id, name FROM incomes_category_assigned_to_users WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
        $stmt->close();
        return $categories;
    }

    public function addIncome($userId, $categoryId, $amount, $date, $comment)
    {
        $stmt = $this->connection->prepare("INSERT INTO incomes (user_id, income_category_assigned_to_user_id, amount, date_of_income, income_comment) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisss", $userId, $categoryId, $amount, $date, $comment);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }
}
