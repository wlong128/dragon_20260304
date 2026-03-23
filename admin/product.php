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
    // 設定 SQL 查詢指令，使用 LEFT JOIN 連接 product 和 product_type 兩個資料表，並依照建立時間降冪排序
    $sql = "SELECT * FROM product LEFT JOIN product_type USING(product_type_id) ORDER BY create_at DESC";
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
    <title>產品管理</title>
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
            <h1>產品管理</h1>
            <table class="table table-striped">
                <tr>
                    <th>編號</th>
                    <th>產品名稱</th>
                    <th>產品圖片</th>
                    <th>價格</th>
                    <th>分類</th>
                    <th>瀏覽次數</th>
                    <th>狀態</th>
                    <th>建立時間</th>
                    <th>功能</th>
                </tr>
            <?php
            // 迴圈讀取 $table 中的每一筆資料，並將其存入 $row 變數中(一維陣列)1
            while ($row = mysqli_fetch_assoc($table)) {
                echo "<tr>";
                echo "<td>".$row['product_id']."</td>";
                echo "<td>".$row['product_name']."</td>";
                echo '<td><img src="../upload/'.$row['product_img'].'" style="height:50px" alt=""></td>';
                echo "<td>".$row['product_price']."</td>";
                echo "<td>".$row['product_type']."</td>";
                echo "<td>".$row['views']."</td>";
                echo "<td>".$row['product_state']."</td>";
                echo '<td>'.$row['create_at'].'</td>';
                echo '<td><a href="product_edit.php?p='.$row['product_id'].'" class="btn btn-primary">編輯</a></td>';
                echo "</tr>";
            }
            ?>
            </table>
        </div>
    </main>
    <footer>
        <!-- place footer here -->
    </footer>
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