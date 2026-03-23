<?php
// 引用 config.php 檔案，該檔案包含了資料庫連線設定和時區設定
include_once('../admin/config.php');

// try-catch 是 PHP 5 以後才有的語法，
// 主要用來捕捉程式執行過程中可能發生的錯誤，
// 並進行適當的處理，以避免程式崩潰或產生未預期的行為。
try {
    if(!isset($_GET['t'])) {
        $arr['success'] = false;
        $api = json_encode($arr, JSON_UNESCAPED_UNICODE);
        echo $api;
        die();
    }else {
        $t = $_GET['t'];
    }
    // 建立資料庫連線
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    // 設定連線編碼為 UTF-8
    mysqli_set_charset($conn, 'utf8');
    // 設定 SQL 查詢指令
    $sql = "SELECT * FROM product WHERE product_state = '上架' AND product_type_id = $t";
    // 執行 SQL 查詢指令，並將結果存入 $table 變數中(二維陣列)
    $result = mysqli_query($conn, $sql);
    $i = 0;
    while ($row_rs_items = $result->fetch_assoc()) {
        $row[$i]['id'] = $row_rs_items['product_id'];
        $row[$i]['name'] = $row_rs_items['product_name'];
        $row[$i]['price'] = $row_rs_items['product_price'];
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
