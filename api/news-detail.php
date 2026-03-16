<?php
// 引用 config.php 檔案，該檔案包含了資料庫連線設定和時區設定
include_once('../admin/config.php');

// try-catch 是 PHP 5 以後才有的語法，
// 主要用來捕捉程式執行過程中可能發生的錯誤，
// 並進行適當的處理，以避免程式崩潰或產生未預期的行為。
try {
    $id = $_GET['p'];
    // 建立資料庫連線
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    // 設定連線編碼為 UTF-8
    mysqli_set_charset($conn, 'utf8');
    // 設定 SQL 查詢指令
    $sql = "SELECT * FROM news WHERE is_publish = '1' AND news_id = '$id'";
    // 執行 SQL 查詢指令，並將結果存入 $table 變數中(二維陣列)
    $result = mysqli_query($conn, $sql);
    // 取後筆數，當筆數大於 0 時，將資料存入 $row 陣列中，並回傳 JSON 格式的資料
    $count = mysqli_num_rows($result);
    if($count > 0) {
        $i = 0;
        while ($row_rs_items = $result->fetch_assoc()) {
            $row[$i]['id'] = $row_rs_items['news_id'];
            $row[$i]['title'] = $row_rs_items['title'];
            $row[$i]['date'] = $row_rs_items['created_at'];
            $row[$i]['img'] = $row_rs_items['image'];
            $row[$i]['views'] = $row_rs_items['views'];
            $row[$i]['author'] = $row_rs_items['author'];
            $row[$i]['content'] = $row_rs_items['content'];
            $i++;
        };
        $arr['success'] = true;
        $arr['data'] = $row;
        $api = json_encode($arr, JSON_UNESCAPED_UNICODE);
        echo $api;

        // 更新瀏覽次數
        $sql = "UPDATE news SET views = views + 1 WHERE news_id = '$id'";
        mysqli_query($conn, $sql);
    }
    

} catch (Exception $e) {
    echo "連線失敗: " . $e->getMessage();
    die();
}
