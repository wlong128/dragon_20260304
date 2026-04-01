<?php
// 引用 config.php 檔案，該檔案包含了資料庫連線設定和時區設定
include_once('config.php');

// try-catch 是 PHP 5 以後才有的語法，
// 主要用來捕捉程式執行過程中可能發生的錯誤，
// 並進行適當的處理，以避免程式崩潰或產生未預期的行為。
try{
    // 建立資料庫連線
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    // 設定連線編碼為 UTF-8
    mysqli_set_charset($conn, 'utf8');
    // 設定 SQL 查詢指令
    $sql = "SELECT * FROM news ORDER BY created_at DESC";
    // 執行 SQL 查詢指令，並將結果存入 $table 變數中(二維陣列)
    $table = mysqli_query($conn, $sql);
}
catch (Exception $e) {
    echo "連線失敗: " . $e->getMessage();
    die();
}

// var_dump($conn);


?>
<!doctype html>
<html lang="en">

<head>
    <title>新聞管理</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="css/admin.css">
</head>

<body>
    <header>
        <?php include_once('nav.php') ?>
    </header>
    <main>
        <div class="container py-5">
            <h1>新聞管理</h1>
            <table class="table table-striped">
                <tr>
                    <th>編號</th>
                    <th>新聞標題</th>
                    <th>焦點圖片</th>
                    <th>日期</th>
                    <th>作者</th>
                    <th>次數</th>
                    <th>上架否</th>
                    <th>功能</th>
                </tr>
            <?php
            // 迴圈讀取 $table 中的每一筆資料，並將其存入 $row 變數中(一維陣列)1
            while ($row = mysqli_fetch_assoc($table)) {
                echo "<tr>";
                echo "<td>".$row['news_id']."</td>";
                echo "<td>".$row['title']."</td>";
                //
                echo '<td><img src="../upload/'.$row['image'].'" style="height:50px" alt=""></td>';
                echo '<td>'.$row['created_at'].'</td>';
                echo "<td>".$row['author']."</td>";
                echo "<td>".$row['views']."</td>";
                echo "<td>".$row['is_publish']."</td>";
                echo '<td><a href="news_edit.php?p='.$row['news_id'].'" class="btn btn-primary">編輯</a> <a href="news_del.php?p='.$row['news_id'].'" class="btn btn-danger" onclick="return confirm(\'你確定要刪除嗎？\')">刪除</a></td>';
                echo "</tr>";
            }
            ?>
            </table>
        </div>
    </main>
        
    <!-- 引入外部檔案 footer.html -->
    <div w3-include-html="footer.html"></div>
    
    <!-- Bootstrap JavaScript Libraries -->
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>