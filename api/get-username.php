<?php
// 設定 SQL 查詢指令
$sql = "SELECT username, timeout_at FROM member INNER JOIN login_log USING(username) WHERE token = '$token'";
// 執行 SQL 查詢指令，並將結果存入 $table 變數中(二維陣列)
$result = mysqli_query($conn, $sql);
while ($row_rs_items = $result->fetch_assoc()) {
    $username = $row_rs_items['username'];
    $timeout_at = $row_rs_items['timeout_at'];
};
// 判斷登入逾期，若逾期則回傳 JSON 格式的資料 {"success": false, "message": "登入逾期，請重新登入"}
if(strtotime($timeout_at) < time()) {
    $arr['success'] = false;
    $arr['message'] = '登入逾期，請重新登入';
    $api = json_encode($arr, JSON_UNESCAPED_UNICODE);
    echo $api;
    die();
}
?>