<?php

function loadClass($c)
{
    include ROOT . "/classes/" . $c . ".class.php";
}

function getIndex($index, $value = '')
{
    $data = isset($_GET[$index]) ? $_GET[$index] : $value;
    return $data;
}

function postIndex($index, $value = '')
{
    $data = isset($_POST[$index]) ? $_POST[$index] : $value;
    return $data;
}

function requestIndex($index, $value)
{
    $data = isset($_REQUEST[$index]) ? $_REQUEST[$index] : $value;
    return $data;
}

// Lấy ngày hiện tại
function getCurrentDate() {
    return date('dd-mm-yy');
}

// Lấy thời gian hiện tại
function getCurrentTime() {
    return date('H:i:s');
}

// Tính số ngày giữa hai ngày
function daysBetween($startDate, $endDate) {
    $start = strtotime($startDate);
    $end = strtotime($endDate);
    return ($end - $start) / (60 * 60 * 24);
}


// Chuyển đổi chuỗi thành chữ thường
function toLowerCase($str) {
    return strtolower($str);
}

// Chuyển đổi chuỗi thành chữ hoa
function toUpperCase($str) {
    return strtoupper($str);
}

// Cắt chuỗi theo độ dài
function truncateString($str, $length) {
    return substr($str, 0, $length);
}


// Đọc nội dung tệp tin
function readFileContent($filePath) {
    if (file_exists($filePath)) {
        return file_get_contents($filePath);
    } else {
        return false;
    }
}

// Ghi nội dung vào tệp tin
function writeFileContent($filePath, $content) {
    return file_put_contents($filePath, $content);
}

// Kiểm tra xem tệp tin có tồn tại không
function fileExists($filePath) {
    return file_exists($filePath);
}


// Kiểm tra xem một giá trị có tồn tại trong mảng không
function inArray($needle, $haystack) {
    return in_array($needle, $haystack);
}

// Gộp các phần tử của mảng thành chuỗi
function arrayToString($array, $delimiter = ',') {
    return implode($delimiter, $array);
}

// Lọc các giá trị null hoặc trống khỏi mảng
function filterArray($array) {
    return array_filter($array, function($value) {
        return !empty($value);
    });
}


// Mã hóa mật khẩu
function hashPassword($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

// Kiểm tra mật khẩu
function verifyPassword($password, $hash)
{
    return password_verify($password, $hash);
}

// Xử lý đầu vào để tránh SQL Injection
function sanitizeInput($input)
{
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}

// Kiểm tra email hợp lệ
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Kiểm tra số điện thoại hợp lệ (đơn giản)
function isValidPhone($phone) {
    return preg_match('/^[0-9]{10,11}$/', $phone);
}

// Kiểm tra URL hợp lệ
function isValidURL($url) {
    return filter_var($url, FILTER_VALIDATE_URL);
}


?>