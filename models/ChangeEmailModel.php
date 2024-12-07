<?php
require_once __DIR__ . '/../connect.php';

class ChangeEmailModel
{
    private $connection;

    public function __construct()
    {
        $this->connection = getDatabaseConnection();
        if ($this->connection->connect_errno) {
            throw new Exception("Database connection error: " . $this->connection->connect_error);
        }
    }

    public function getCurrentEmail($userId)
    {
        $stmt = $this->connection->prepare("SELECT email FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $email = null;
        if ($row = $result->fetch_assoc()) {
            $email = $row['email'];
        }
        $stmt->close();
        return $email;
    }

    public function isEmailTaken($newEmail, $userId)
    {
        $stmt = $this->connection->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->bind_param("si", $newEmail, $userId);
        $stmt->execute();
        $stmt->store_result();
        $isTaken = $stmt->num_rows > 0;
        $stmt->close();
        return $isTaken;
    }

    public function updateEmail($newEmail, $userId)
    {
        $stmt = $this->connection->prepare("UPDATE users SET email = ? WHERE id = ?");
        $stmt->bind_param("si", $newEmail, $userId);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function closeConnection()
    {
        $this->connection->close();
    }
}
