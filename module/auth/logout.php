<?php
session_start();

if(isset($_SESSION['username'])){
    unset($_SESSTION['username']);
}
session_destroy();
header("Location: ../../index.php");
exit;
?>
