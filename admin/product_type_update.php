<?php
// 引用 config.php 檔案，該檔案包含了資料庫連線設定和時區設定
include_once('config.php');

try{
    // 判斷是否由表單送出資料
    if(!isset($_POST['product_type'])){
        echo "請從表單提交資料 <a href='product_type_post.php'>返回</a>";
        die();
    }
    // 取得表單資料
    $id = $_POST['product_type_id'];
    $product_type = $_POST['product_type'];
    
    // 建立資料庫連線
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    // 設定連線編碼為 UTF-8
    mysqli_set_charset($conn, 'utf8');
    // 設定 SQL update指令
    $sql = "UPDATE product_type SET product_type = '$product_type' WHERE product_type_id = $id";
    
    // echo $sql;
    // 執行 SQL 查詢指令 
    if(mysqli_query($conn, $sql)){
        header("Location: product_type.php");
    }
}
catch (Exception $e) {
    echo "連線失敗: " . $e->getMessage();
    die();
}
?>