<?php
// 啟用 session 功能，以便在不同頁面之間共享資料
session_start();

// 資料庫連線設定
$db_host = 'localhost';
$db_name = 'dragon20260304';
$db_user = 'dragon_20260304';
$db_pass = '1234';

// 設定時區為台北
date_default_timezone_set("Asia/Taipei");
?>