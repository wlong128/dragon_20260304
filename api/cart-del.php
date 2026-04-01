<?php
// 引用 config.php 檔案，該檔案包含了資料庫連線設定和時區設定
include_once('../admin/config.php');

// try-catch 是 PHP 5 以後才有的語法，
// 主要用來捕捉程式執行過程中可能發生的錯誤，
// 並進行適當的處理，以避免程式崩潰或產生未預期的行為。
try {
    if(!isset($_POST['token'])) {
        $arr['success'] = false;
        $arr['message'] = '操作錯誤';
        $api = json_encode($arr, JSON_UNESCAPED_UNICODE);
        echo $api;
        die();
    }
    $token = $_POST['token'];
    $cart_id = $_POST['cart_id'];
    // 建立資料庫連線
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    // 設定連線編碼為 UTF-8
    mysqli_set_charset($conn, 'utf8');

    // 引用 get-username.php 檔案，該檔案包含了根據 token 取得 username 的邏輯
    include_once('get-username.php');

    $sql = "DELETE FROM cart WHERE cart_id = '$cart_id' AND username = '$username'";
    mysqli_query($conn, $sql);


    $arr['success'] = true;
    $arr['message'] = '已成功從購物車中刪除商品';
    $api = json_encode($arr, JSON_UNESCAPED_UNICODE);
    echo $api;
} catch (Exception $e) {
    echo "連線失敗: " . $e->getMessage();
    die();
}
