<?php
class ChangeNameModel
{
    private $connection;

    public function __construct()
    {
        $this->connection = $this->getDatabaseConnection();
    }

    public function getDatabaseConnection()
    {
        $host = 'budget.marek-balowski.profesjonalnyprogramista.pl.mysql.dhosting.pl';
        $user = 'poh9ee_budgetma';
        $password = 'zahnah6EiZoo';
        $database = 'phee3y_budgetma';

        $connection = new mysqli($host, $user, $password, $database);

        if ($connection->connect_errno) {
            echo "Failed to connect to MySQL: " . $connection->connect_error;
            exit();
        }

        return $connection;
    }

    public function changeUsername($userId, $newUsername)
    {
        $stmt = $this->connection->prepare("UPDATE users SET username = ? WHERE id = ?");
        $stmt->bind_param("si", $newUsername, $userId);
        $stmt->execute();
        $stmt->close();
    }
}
