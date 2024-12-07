<?php

class ExpensesModel
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getCategories($userId)
    {
        $stmt = $this->connection->prepare("SELECT id, name FROM expenses_category_assigned_to_users WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
        $stmt->close();
        return $categories;
    }

    public function getPaymentMethods($userId)
    {
        $stmt = $this->connection->prepare("SELECT id, name FROM payment_methods_assigned_to_users WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $paymentMethods = [];
        while ($row = $result->fetch_assoc()) {
            $paymentMethods[] = $row;
        }
        $stmt->close();
        return $paymentMethods;
    }
}
