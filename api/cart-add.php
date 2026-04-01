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
    $product_id = $_POST['product_id'];
    // 建立資料庫連線
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    // 設定連線編碼為 UTF-8
    mysqli_set_charset($conn, 'utf8');

    // 引用 get-username.php 檔案，該檔案包含了根據 token 取得 username 的邏輯
    include_once('get-username.php');

    // 判斷當前帳號的購物車中是否已經有該產品，若有則將數量加 1，若沒有則加入購物車
    $sql = "SELECT * FROM cart WHERE product_id = '$product_id' AND username = '$username'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
        $sql = "UPDATE cart SET count = count + 1 WHERE product_id = '$product_id' AND username = '$username'";
        mysqli_query($conn, $sql);
    }else{
        // 設定 SQL 加入購物車指令
        $sql = "INSERT INTO cart (username, product_id) VALUES ('$username', '$product_id')";
        // 執行 SQL 加入購物車指令
        mysqli_query($conn, $sql);
    }

    $arr['success'] = true;
    $arr['message'] = '已成功加入購物車';
    $api = json_encode($arr, JSON_UNESCAPED_UNICODE);
    echo $api;
} catch (Exception $e) {
    echo "連線失敗: " . $e->getMessage();
    die();
}
