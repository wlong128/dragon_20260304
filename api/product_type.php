<?php
// 引用 config.php 檔案，該檔案包含了資料庫連線設定和時區設定
include_once('../admin/config.php');

// try-catch 是 PHP 5 以後才有的語法，
// 主要用來捕捉程式執行過程中可能發生的錯誤，
// 並進行適當的處理，以避免程式崩潰或產生未預期的行為。
try {
    // 判斷是否有傳入參數 t，如果沒有則預設為 "%"，表示查詢所有產品類型
    if(!isset($_GET['t'])) {
        $type_id = "%";
    } else {
        $type_id = $_GET['t'];
    }
    // 建立資料庫連線
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    // 設定連線編碼為 UTF-8
    mysqli_set_charset($conn, 'utf8');
    // 設定 SQL 查詢指令
    $sql = "SELECT * FROM product_type";
    // 執行 SQL 查詢指令，並將結果存入 $table 變數中(二維陣列)
    $result = mysqli_query($conn, $sql);
    $i = 0;
    $type = "";
    while ($row_rs_items = $result->fetch_assoc()) {
        $row[$i]['id'] = $row_rs_items['product_type_id'];
        $row[$i]['type'] = $row_rs_items['product_type'];
        // 判斷目前指定的產品類型名稱
        if($type_id==$row_rs_items['product_type_id']) {
            $type = $row_rs_items['product_type'];
        }
        $i++;
    };
    $arr['success'] = true;
    $arr['data'] = $row;
    $arr['type'] = $type;
    $api = json_encode($arr, JSON_UNESCAPED_UNICODE);
    echo $api;
} catch (Exception $e) {
    echo "連線失敗: " . $e->getMessage();
    die();
}
