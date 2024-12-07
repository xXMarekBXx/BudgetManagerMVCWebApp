<?php
require_once "../connect.php";

class UserModel
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

    public function userExists($name, $email)
    {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $name, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public function registerUser($name, $email, $hashedPassword)
    {
        $stmt = $this->connection->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashedPassword);
        $stmt->execute();
        return $this->connection->insert_id;
    }

    public function assignDefaultCategories($userId)
    {
        $this->assignDefaultCategory("incomes_category_default", "incomes_category_assigned_to_users", $userId);
        $this->assignDefaultCategory("payment_methods_default", "payment_methods_assigned_to_users", $userId);
        $this->assignDefaultCategory("expenses_category_default", "expenses_category_assigned_to_users", $userId);
    }

    private function assignDefaultCategory($defaultTable, $userTable, $userId)
    {
        $query = "SELECT name FROM $defaultTable";
        $result = $this->connection->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $name = $row['name'];
                $stmt = $this->connection->prepare("INSERT INTO $userTable (user_id, name) VALUES (?, ?)");
                $stmt->bind_param("is", $userId, $name);
                $stmt->execute();
            }
        }
    }

    public function __destruct()
    {
        $this->connection->close();
    }
}
