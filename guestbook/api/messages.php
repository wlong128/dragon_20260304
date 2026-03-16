<?php
header("Content-Type: application/json");
require_once "db.php";
$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents("php://input"), true);

function response($status, $message, $data = null)
{
    echo json_encode([
        "status" => $status,
        "message" => $message,
        "data" => $data
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

switch ($method) {
    /* 讀取留言 */
    case "GET":
        $sql = "SELECT * FROM messages ORDER BY id DESC";
        $result = mysqli_query($conn, $sql);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        response(true, "success", $rows);
        break;
    /* 新增留言 */
    case "POST":
        $name = $data['name'] ?? "";
        $content = $data['content'] ?? "";
        if ($name == "" || $content == "") {
            response(false, "資料不可為空");
        }
        $name = mysqli_real_escape_string($conn, $name);
        $content = mysqli_real_escape_string($conn, $content);
        $sql = "INSERT INTO messages(name,content)VALUES('$name','$content')";
        mysqli_query($conn, $sql);
        response(true, "新增成功");
        break;
    /* 修改留言 */
    case "PUT":
        $id = $data['id'] ?? 0;
        $name = $data['name'] ?? "";
        $content = $data['content'] ?? "";
        if ($id == 0) {
            response(false, "ID錯誤");
        }
        $name = mysqli_real_escape_string($conn, $name);
        $content = mysqli_real_escape_string($conn, $content);
        $sql = "UPDATE messages SET name='$name', content='$content' WHERE id=$id";
        mysqli_query($conn, $sql);
        response(true, "修改成功");
        break;
    /* 刪除留言 */
    case "DELETE":
        $id = $data['id'] ?? 0;
        if ($id == 0) {
            response(false, "ID錯誤");
        }
        $sql = "DELETE FROM messages WHERE id=$id";
        mysqli_query($conn, $sql);
        response(true, "刪除成功");
        break;
}
