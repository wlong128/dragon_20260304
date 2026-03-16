<?php
// 引用 config.php 檔案，該檔案包含了資料庫連線設定和時區設定
include_once('../admin/config.php');

// try-catch 是 PHP 5 以後才有的語法，
// 主要用來捕捉程式執行過程中可能發生的錯誤，
// 並進行適當的處理，以避免程式崩潰或產生未預期的行為。
try {
    $username = $_POST['username'];
    // 使用 password_hash() 函數對密碼進行加密，並指定使用預設的加密算法
    $password = $_POST['password'];

    // $username = "test";
    // $password = "1234";

    // 建立資料庫連線
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    // 設定連線編碼為 UTF-8
    mysqli_set_charset($conn, 'utf8');

    // 設定 SQL 查詢預處理指令，使用 mysqli_prepare() 函數來準備 SQL 查詢指令，並將結果存入 $stmt 變數中
    $sql = "SELECT * FROM member WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    // 綁定參數
    mysqli_stmt_bind_param($stmt, "s", $username);
    // 執行 SQL 查詢指令，並將結果存入 $result 變數中(二維陣列)
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    // 取得查詢結果的行數，並將其存入 $total 變數中
    $total = mysqli_num_rows($result);
    

    if($total > 0) {
        // 使用 mysqli_fetch_assoc() 函數從 $result 中取得一行資料，並將其存入 $row 變數中(一維陣列)
        $row = mysqli_fetch_assoc($result);
        // 判斷 password_verify() 函數來驗證使用者輸入的密碼是否與資料庫中存儲的加密密碼相符
        if (password_verify($password, $row['password'])) {
            // 密碼驗證成功，回傳 JSON 格式的資料 {"success": true, "message": "登入成功"}
            echo json_encode(array("success" => true, "message" => "登入成功"));
        } else {
            // 密碼驗證失敗，回傳 JSON 格式的資料 {"success": false, "message": "密碼錯誤"}
            echo json_encode(array("success" => false, "message" => "密碼錯誤"));
        }
    } else {
        // 查無此帳號，回傳 JSON 格式的資料 {"success": false, "message": "查無此帳號"}
        echo json_encode(array("success" => false, "message" => "查無此帳號"));
    }

} catch (Exception $e) {
    echo json_encode(array("success" => false, "message" => "連線失敗: " . $e->getMessage()));
    die();
}
