<?php
include_once("../../admin/config.php");
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$conn) {
    die("Database connection failed");
}
mysqli_set_charset($conn, "utf8mb4");
?>
