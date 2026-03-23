<?php
// 引用 config.php 檔案，該檔案包含了資料庫連線設定和時區設定
include_once('config.php');

try{
    // 判斷是否由表單送出資料
    if(!isset($_GET['p'])) {
        echo "請從表單提交資料 <a href='product.php'>返回</a>";
        die();
    }
    // 取得表單資料
    $p = $_GET['p'];
    
    // 建立資料庫連線
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    // 設定連線編碼為 UTF-8
    mysqli_set_charset($conn, 'utf8');
    // 設定 SQL select指令
    $sql = "SELECT * FROM product WHERE product_id = $p";
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
    <title>產品編輯</title>
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
            <h1>產品編輯</h1>
            <?php
            // 迴圈讀取 $table 中的每一筆資料，並將其存入 $row 變數中(一維陣列)1
            while ($row = mysqli_fetch_assoc($table)) {
            ?>
            <form action="product_update.php" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="product_name" class="form-label">產品名稱</label>
                        <input type="text" class="form-control" id="product_name" name="product_name" value="<?= $row['product_name'] ?>" />
                    </div>
                    <div class="col-12 mb-3">
                        <label for="product_img" class="form-label">產品圖片</label>
                        <input type="file" class="form-control" id="product_img" name="product_img" />
                        <img src="../upload/<?= $row['product_img'] ?>" alt="">
                        <input type="hidden" name="old_product_img" value="<?= $row['product_img'] ?>">
                    </div>
                    <div class="col-12 mb-3">
                        <label for="product_content" class="form-label">產品介紹</label>
                        <textarea name="product_content" id="product_content" class="form-control" rows="8"><?= $row['product_content'] ?></textarea>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="product_price" class="form-label">產品價格</label>
                        <input type="number" class="form-control" id="product_price" name="product_price" value="<?= $row['product_price'] ?>" />
                    </div>
                    <div class="col-12 mb-3">
                        <label for="product_type_id" class="form-label">產品分類</label>
                        <select class="form-select" name="product_type_id" id="product_type_id">
                            <option value="">請選擇產品分類</option>
                            <?php
                            // 設定 SQL 查詢指令
                            $sql = "SELECT * FROM product_type";
                            // 執行 SQL 查詢指令，並將結果存入 $type 變數中(二維陣列)
                            $type = mysqli_query($conn, $sql);
                            // 迴圈讀取 $table 中的每一筆資料，並將其存入 $row 變數中(一維陣列)1
                            while ($r = mysqli_fetch_assoc($type)) {
                                $id = $r['product_type_id'];
                                $val = $r['product_type'];
                                $selected = ($id == $row['product_type_id']) ? 'selected' : '';
                                echo "<option value=\"$id\" $selected>$val</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="product_state" class="form-label">是否直接上架</label>
                        <select class="form-control" id="product_state" name="product_state">
                            <option value="下架" <?= $row['product_state'] == '下架' ? 'selected' : '' ?>>下架</option>
                            <option value="上架" <?= $row['product_state'] == '上架' ? 'selected' : '' ?>>上架</option>
                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
                        <input type="submit" value="更新" class="btn btn-primary" />
                    </div>
                </div>
            </form>
            <?php } ?>
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