<?php
require_once '../../config/config.php';
require_once '../../classes/Db.class.php';
require_once '../../classes/Notification.class.php';

$db = new Db();
$notification = new Notification($db);
$unreadNotifications = $notification->getUnreadNotifications();
$unreadCount = $notification->countUnreadNotifications();
?>

<div class="notification-container">
    <button onclick="toggleNotifications()" class="notification-button">
        Thông báo (<?php echo $unreadCount; ?>)
    </button>
    <div id="notifications-dropdown" class="notifications-dropdown" style="display: none;">
        <?php if (!empty($unreadNotifications)): ?>
            <ul>
                <?php foreach ($unreadNotifications as $notif): ?>
                    <li>
                        <p><?php echo htmlspecialchars($notif['message']); ?></p>
                        <small><?php echo date('d/m/Y H:i', strtotime($notif['created_at'])); ?></small>
                        <form action="mark_as_read.php" method="post" style="display: inline-block;">
                            <input type="hidden" name="notification_id" value="<?php echo $notif['notification_id']; ?>">
                            <button type="submit">Đánh dấu đã đọc</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Không có thông báo mới</p>
        <?php endif; ?>
    </div>
</div>

<script>
    function toggleNotifications() {
        var dropdown = document.getElementById('notifications-dropdown');
        dropdown.style.display = (dropdown.style.display === 'none' || dropdown.style.display === '') ? 'block' : 'none';
    }
</script>
