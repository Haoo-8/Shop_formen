setInterval(function () {
    fetch('module/admin/get_notifications.php')
        .then(response => response.json())
        .then(data => {
            document.querySelector('.notification-button').textContent = `Thông báo (${data.unread_count})`;
            // Cập nhật nội dung dropdown (nếu cần)
        });
}, 10000);
