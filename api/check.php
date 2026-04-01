<?php
// 引用 config.php 檔案，該檔案包含了資料庫連線設定和時區設定
include_once('../admin/config.php');

// try-catch 是 PHP 5 以後才有的語法，
// 主要用來捕捉程式執行過程中可能發生的錯誤，
// 並進行適當的處理，以避免程式崩潰或產生未預期的行為。
try {
    $token = $_POST['token'];

    // 建立資料庫連線
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    // 設定連線編碼為 UTF-8
    mysqli_set_charset($conn, 'utf8');

    // 設定 SQL 查詢預處理指令，使用 mysqli_prepare() 函數來準備 SQL 查詢指令，並將結果存入 $stmt 變數中
    $sql = "SELECT * FROM login_log WHERE token = ?";
    $stmt = mysqli_prepare($conn, $sql);
    // 綁定參數
    mysqli_stmt_bind_param($stmt, "s", $token);
    // 執行 SQL 查詢指令，並將結果存入 $result 變數中(二維陣列)
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    // 取得查詢結果的行數，並將其存入 $total 變數中
    $total = mysqli_num_rows($result);
    

    if($total > 0) {
        // 使用 mysqli_fetch_assoc() 函數從 $result 中取得一行資料，並將其存入 $row 變數中(一維陣列)
        $row = mysqli_fetch_assoc($result);
        // 判斷 token 是否過期，若未過期則回傳 JSON 格式的資料 {"success": true, "message": "驗證成功"}
        if ($row['timeout_at'] > date('Y-m-d H:i:s')) {
            // token 驗證成功，更新 token 的過期時間，將 timeout_at 欄位的值更新為目前時間加 1 小時
            $now = date('Y-m-d H:i:s', strtotime('+1 HOUR'));
            // 更新 token 的過期時間，將 timeout_at 欄位的值更新為目前時間
            $sql = "UPDATE login_log SET timeout_at = '$now' WHERE token = '$token'";
            mysqli_query($conn, $sql);
            echo json_encode(array("success" => true, "message" => "token 驗證成功"));
        } else {
            echo json_encode(array("success" => false, "message" => "token 已過期"));
        }
    } else {
        // 查無此帳號，回傳 JSON 格式的資料 {"success": false, "message": "查無此帳號"}
        echo json_encode(array("success" => false, "message" => "token 已過期"));
        // 清空session資料
        session_destroy();

    }

} catch (Exception $e) {
    echo json_encode(array("success" => false, "message" => "連線失敗: " . $e->getMessage()));
    die();
}
