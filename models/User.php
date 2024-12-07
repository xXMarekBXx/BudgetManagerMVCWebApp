<?php
require_once "connect.php";

class User
{
    private $connection;

    public function __construct()
    {
        $dbHost = getenv('DB_HOST');
        $dbUser = getenv('DB_USER');
        $dbPassword = getenv('DB_PASSWORD');
        $dbName = getenv('DB_NAME');

        $this->connection = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

        if ($this->connection->connect_errno) {
            die("Database connection failed: " . $this->connection->connect_error);
        }
    }

    public function getUserByEmail(string $email): ?array
    {
        $stmt = $this->connection->prepare("SELECT id, username, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $username, $password);
            $stmt->fetch();

            return [
                'id' => $id,
                'username' => $username,
                'password' => $password
            ];
        }

        return null;
    }

    public function __destruct()
    {
        $this->connection->close();
    }
}
