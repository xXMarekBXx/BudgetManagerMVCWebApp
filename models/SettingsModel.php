<?php
class SettingsModel
{
    private $db;

    public function __construct()
    {
        require_once __DIR__ . '/../connect.php';
        $this->db = getDatabaseConnection();
    }

    public function getUserData($session)
    {
        if (!isset($session['user_id'])) {
            error_log('Session does not have user_id.');
            return null;
        }

        $userId = $session['user_id'];
        if ($userId === null) {
            error_log('User ID is null.');
            return null;
        }

        $query = "SELECT id AS user_id, username FROM users WHERE id = ?";
        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            $userData = $result->fetch_assoc();
            if (!$userData) {
                error_log('No user data found for user_id ' . $userId);
                return null;
            }

            return $userData;
        } else {
            error_log('Failed to prepare statement: ' . $this->db->error);
            return null;
        }
    }
}
