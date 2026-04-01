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
    // 建立資料庫連線
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    // 設定連線編碼為 UTF-8
    mysqli_set_charset($conn, 'utf8');

    // 引用 get-username.php 檔案，該檔案包含了根據 token 取得 username 的邏輯
    include_once('get-username.php');

    // 設定 SQL 查詢指令
    $sql = "SELECT *, (product_price * count) AS total FROM cart INNER JOIN product USING(product_id) WHERE username = '$username'";
    // 執行 SQL 查詢指令，並將結果存入 $table 變數中(二維陣列)
    $result = mysqli_query($conn, $sql);
    $i = 0;
    while ($row_rs_items = $result->fetch_assoc()) {
        $row[$i]['id'] = $row_rs_items['cart_id'];
        $row[$i]['product_id'] = $row_rs_items['product_id'];
        $row[$i]['product_name'] = $row_rs_items['product_name'];
        $row[$i]['product_price'] = $row_rs_items['product_price'];
        $row[$i]['count'] = $row_rs_items['count'];
        $row[$i]['total'] = $row_rs_items['total'];
        $row[$i]['username'] = $row_rs_items['username'];
        $row[$i]['created_at'] = $row_rs_items['created_at'];
        $i++;
    };
    $arr['success'] = true;
    $arr['data'] = $row;
    $api = json_encode($arr, JSON_UNESCAPED_UNICODE);
    echo $api;
} catch (Exception $e) {
    echo "連線失敗: " . $e->getMessage();
    die();
}
