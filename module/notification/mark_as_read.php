<?php
require_once '../../config/config.php';
require_once '../../classes/Db.class.php';
require_once '../../classes/Notification.class.php';

$db = new Db();
$notification = new Notification($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['notification_id'])) {
    $notificationId = intval($_POST['notification_id']);
    $notification->markAsRead($notificationId);
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
?>
