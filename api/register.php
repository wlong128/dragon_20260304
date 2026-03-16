<?php
// 引用 config.php 檔案，該檔案包含了資料庫連線設定和時區設定
include_once('../admin/config.php');

// try-catch 是 PHP 5 以後才有的語法，
// 主要用來捕捉程式執行過程中可能發生的錯誤，
// 並進行適當的處理，以避免程式崩潰或產生未預期的行為。
try {
    $username = $_POST['username'];
    // 使用 password_hash() 函數對密碼進行加密，並指定使用預設的加密算法
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $name = $_POST['name'];
    $email = $_POST['email'];

    // $username = "test2";
    // $password = password_hash("1234", PASSWORD_DEFAULT);
    // $name = "測試";
    // $email = "test2@yahoo.com";

    // 建立資料庫連線
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    // 設定連線編碼為 UTF-8
    mysqli_set_charset($conn, 'utf8');

    // 設定 SQL 查詢預處理指令，使用 mysqli_prepare() 函數來準備 SQL 查詢指令，並將結果存入 $stmt 變數中
    $sql = "INSERT INTO member (username, password, email, name) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    // 綁定參數
    mysqli_stmt_bind_param($stmt, "ssss", $username, $password, $email, $name);
    // 執行 SQL 查詢指令，並將結果存入 $table 變數中(二維陣列)
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        // API 回傳 JSON 格式的資料 {"success": true, "message": "註冊成功"}
        echo json_encode(array("success" => true, "message" => "註冊成功"));
    } else {
        echo json_encode(array("success" => false, "message" => "註冊失敗: " . mysqli_error($conn)));
    }

} catch (Exception $e) {
    echo json_encode(array("success" => false, "message" => "連線失敗: " . $e->getMessage()));
    die();
}
