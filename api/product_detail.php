<?php
// 引用 config.php 檔案，該檔案包含了資料庫連線設定和時區設定
include_once('../admin/config.php');

// try-catch 是 PHP 5 以後才有的語法，
// 主要用來捕捉程式執行過程中可能發生的錯誤，
// 並進行適當的處理，以避免程式崩潰或產生未預期的行為。
try {
    if(!isset($_GET['p'])) {
        die("false");
    }else {
        $p = $_GET['p'];
    }
    // 建立資料庫連線
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    // 設定連線編碼為 UTF-8
    mysqli_set_charset($conn, 'utf8');
    // 設定 SQL 查詢指令
    $sql = "SELECT * FROM product INNER JOIN product_type USING(product_type_id) WHERE product_state = '上架' AND product_id = '$p'";
    // echo $sql;
    // 執行 SQL 查詢指令，並將結果存入 $table 變數中(二維陣列)
    $result = mysqli_query($conn, $sql);
    // var_dump($result);
    $i = 0;
    while ($row_rs_items = $result->fetch_assoc()) {
        $row[$i]['id'] = $row_rs_items['product_id'];
        $row[$i]['name'] = $row_rs_items['product_name'];
        $row[$i]['img'] = $row_rs_items['product_img'];
        // nl to br 將換行符號轉換成 HTML 的 <br> 標籤，以便在網頁上正確顯示換行
        $row[$i]['content'] = nl2br($row_rs_items['product_content']);
        $row[$i]['price'] = $row_rs_items['product_price'];
        $row[$i]['type'] = $row_rs_items['product_type'];
        $row[$i]['t'] = $row_rs_items['product_type_id'];
        $i++;
    };
    $arr['success'] = true;
    $arr['data'] = $row;
    $api = json_encode($arr, JSON_UNESCAPED_UNICODE);
    echo $api;

    // 更新瀏覽次數
    $sql = "UPDATE product SET views = views + 1 WHERE product_id = '$p'";
    mysqli_query($conn, $sql);
} catch (Exception $e) {
    echo "連線失敗: " . $e->getMessage();
    die();
}
