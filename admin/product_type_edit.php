<?php
// 引用 config.php 檔案，該檔案包含了資料庫連線設定和時區設定
include_once('config.php');

try{
    // 判斷是否由表單送出資料
    if(!isset($_GET['p'])) {
        echo "請從表單提交資料 <a href='product_type.php'>返回</a>";
        die();
    }
    // 取得表單資料
    $p = $_GET['p'];
    
    // 建立資料庫連線
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    // 設定連線編碼為 UTF-8
    mysqli_set_charset($conn, 'utf8');
    // 設定 SQL select指令
    $sql = "SELECT * FROM product_type WHERE product_type_id = $p";
    // 執行 SQL 查詢指令，並將結果存入 $table 變數中(二維陣列)
    $table = mysqli_query($conn, $sql);

}
catch (Exception $e) {
    echo "連線失敗: " . $e->getMessage();
    die();
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>產品分類編輯</title>
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
            <h1>產品分類編輯</h1>
            <?php
            // 迴圈讀取 $table 中的每一筆資料，並將其存入 $row 變數中(一維陣列)1
            while ($row = mysqli_fetch_assoc($table)) {
            ?>
            <form action="product_type_update.php" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="product_type" class="form-label">產品分類名稱</label>
                        <input type="text" class="form-control" id="product_type" name="product_type" value="<?= $row['product_type'] ?>" />
                    </div>
                    <div class="col-12 mb-3">
                        <input type="hidden" name="product_type_id" value="<?= $row['product_type_id'] ?>">
                        <input type="submit" value="更新" class="btn btn-primary" />
                    </div>
                </div>
            </form>
            <?php } ?>
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