<?php

function renderBreadcrumb() {
    // Tải cấu hình nhãn breadcrumb
    $labels = include './config/breadcrumb_config.php';

    // Lấy URL hiện tại
    $path = $_SERVER['REQUEST_URI']; 
    $pathParts = explode('/', trim($path, '/')); // Tách các phần trong URL
    
    // Tạo breadcrumb
    $breadcrumbs = [];
    $breadcrumbs[] = ['label' => $labels['index.php'], 'url' => 'index.php']; // Luôn có "Trang chủ"
    $currentPath = '';

    foreach ($pathParts as $part) {
        if ($part === '') continue; // Bỏ qua phần rỗng

        // Loại bỏ đuôi ".php" nếu có
        $cleanPart = str_replace('.php', '', $part);

        // Xây dựng đường dẫn URL
        $currentPath .= '/' . $part;

        // Lấy nhãn từ bảng cấu hình hoặc tự tạo nhãn từ URL
        $label = isset($labels[$cleanPart]) ? $labels[$cleanPart] : ucfirst(str_replace('_', ' ', $cleanPart));

        // Thêm vào breadcrumb
        $breadcrumbs[] = ['label' => $label, 'url' => $currentPath];
    }

    // Hiển thị breadcrumb
    echo '<nav aria-label="breadcrumb">';
    echo '<ul style="list-style:none; display:flex; padding:0;">';
    foreach ($breadcrumbs as $key => $breadcrumb) {
        echo '<li style="margin-right: 5px;">';
        if ($breadcrumb['url'] && $key != count($breadcrumbs) - 1) {
            echo '<a href="' . $breadcrumb['url'] . '" style="text-decoration:none; color:gray;">' . $breadcrumb['label'] . '</a>';
            echo ' / ';
        } else {
            echo '<span style="font-weight:bold; color:black;">' . $breadcrumb['label'] . '</span>';
        }
        echo '</li>';
    }
    echo '</ul>';
    echo '</nav>';
}



function autoBreadcrumb() {
    $path = $_SERVER['PHP_SELF']; // Lấy đường dẫn file
    $path_parts = explode('/', trim($path, '/')); // Tách đường dẫn thành các phần

    echo '<nav aria-label="breadcrumb"><ul style="list-style:none; display:flex; padding:0;">';
    $currentPath = '';
    foreach ($path_parts as $key => $part) {
        $currentPath .= '/' . $part;

        // Tạo nhãn từ phần đường dẫn
        $label = ucfirst(str_replace(['_', '.php'], [' ', ''], $part));
        
        echo '<li style="margin-right: 5px;">';
        if ($key !== count($path_parts) - 1) {
            echo '<a href="' . $currentPath . '" style="text-decoration:none; color:gray;">' . $label . '</a> / ';
        } else {
            echo '<span style="font-weight:bold; color:black;">' . $label . '</span>';
        }
        echo '</li>';
    }
    echo '</ul></nav>';
}
?>
