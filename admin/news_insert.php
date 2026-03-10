<?php
// 引用 config.php 檔案，該檔案包含了資料庫連線設定和時區設定
include_once('config.php');

try{
    // 判斷是否由表單送出資料
    if(!isset($_POST['title'])) {
        echo "請從表單提交資料 <a href='news_post.php'>返回</a>";
        die();
    }
    // 取得表單資料
    $title = $_POST['title'];
    $summary = $_POST['summary'];
    $content = $_POST['content'];
    $author = $_POST['author'];
    $is_publish = $_POST['is_publish'];
    // 產生新的檔名，格式為：年月日時分秒+4位亂數+副檔名
    $rand = rand(1000,9999);
    $time = date("YmdHis").$rand;
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $newname = $time.".".$ext;
    // 將檔案從暫存區移動到指定的資料夾，並使用新的檔名
    move_uploaded_file($_FILES['image']['tmp_name'], "../upload/".$newname);
    // 建立資料庫連線
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    // 設定連線編碼為 UTF-8
    mysqli_set_charset($conn, 'utf8');
    // 設定 SQL insert指令
    $sql = "INSERT INTO news (title, summary, content, image, author, is_publish) VALUES ('$title', '$summary', '$content', '$newname', '$author', '$is_publish');";
    // echo $sql;
    // 執行 SQL 查詢指令 
    if(mysqli_query($conn, $sql)){
        header("Location: news.php");
    }
}
catch (Exception $e) {
    echo "連線失敗: " . $e->getMessage();
    die();
}
?>