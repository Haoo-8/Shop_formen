<?php
class Utility {
    public static function sanitize($input) {
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }

    public static function formatCurrency($amount) {
        return number_format($amount, 2, '.', ',') . ' $';
    }

    public static function getCurrentDate() {
        return date('Y-m-d');
    }

    public static function getCurrentTime() {
        return date('H:i:s');
    }
}
?>
