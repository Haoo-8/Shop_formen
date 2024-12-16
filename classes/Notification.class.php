<?php
class Notification extends Db {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addNotification($orderId, $message) {
        $sql = "INSERT INTO notifications (order_id, message) VALUES (?, ?)";
        return $this->db->insert($sql, [$orderId, $message]);
    }

    public function getUnreadNotifications() {
        $sql = "SELECT * FROM notifications WHERE is_read = 0 ORDER BY created_at DESC";
        return $this->db->select($sql);
    }

    public function markAsRead($notificationId) {
        $sql = "UPDATE notifications SET is_read = 1 WHERE notification_id = ?";
        return $this->db->update($sql, [$notificationId]);
    }

    public function countUnreadNotifications() {
        $sql = "SELECT COUNT(*) AS unread_count FROM notifications WHERE is_read = 0";
        return $this->db->select($sql)[0]['unread_count'];
    }
}
