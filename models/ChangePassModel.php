<?php
require_once __DIR__ . '/../connect.php';

class ChangePassModel
{
    private $connection;

    public function __construct()
    {
        $this->connection = getDatabaseConnection();
        if ($this->connection->connect_errno) {
            throw new Exception("Database connection error: " . $this->connection->connect_error);
        }
    }

    public function getCurrentPasswordHash($userId)
    {
        $stmt = $this->connection->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        $stmt->close();
        return $hashed_password;
    }

    public function updatePassword($userId, $newHashedPassword)
    {
        $stmt = $this->connection->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $newHashedPassword, $userId);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function closeConnection()
    {
        $this->connection->close();
    }
}
