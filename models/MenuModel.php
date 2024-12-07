<?php
class MenuModel
{
    private $connection;

    public function __construct($dbHost, $dbUser, $dbPassword, $dbName)
    {
        $this->connection = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
        if ($this->connection->connect_errno != 0) {
            die("Error: " . $this->connection->connect_errno . " Reason: " . $this->connection->connect_error);
        }
    }

    public function getUserData($userId)
    {
        $query = "SELECT username FROM users WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($username);
        $stmt->fetch();
        $stmt->close();
        return $username;
    }

    public function logout()
    {
        session_unset();
        session_destroy();
    }
}
