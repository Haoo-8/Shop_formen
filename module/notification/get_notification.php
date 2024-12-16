<?php
require_once '../../config/config.php';
require_once '../../classes/Db.class.php';
require_once '../../classes/Notification.class.php';

$db = new Db();
$notification = new Notification($db);

$unreadNotifications = $notification->getUnreadNotifications();
$unreadCount = $notification->countUnreadNotifications();

echo json_encode([
    'unread_count' => $unreadCount,
    'notifications' => $unreadNotifications
]);
?>
