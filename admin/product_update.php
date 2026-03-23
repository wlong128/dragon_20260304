<?php
// 引用 config.php 檔案，該檔案包含了資料庫連線設定和時區設定
include_once('config.php');

try{
    // 判斷是否由表單送出資料
    if(!isset($_POST['product_name'])){
        echo "請從表單提交資料 <a href='product_post.php'>返回</a>";
        die();
    }
    // 取得表單資料
    $id = $_POST['product_id'];
    $name = $_POST['product_name'];
    $price = $_POST['product_price'];
    $content = $_POST['product_content'];
    $type_id = $_POST['product_type_id'];
    $state = $_POST['product_state'];
    $old_images = $_POST['old_product_img'];
    if($_FILES['product_img']['name'] != ''){
        // 產生新的檔名，格式為：年月日時分秒+4位亂數+副檔名
        $rand = rand(1000,9999);
        $time = date("YmdHis").$rand;
        $ext = pathinfo($_FILES['product_img']['name'], PATHINFO_EXTENSION);
        $newname = $time.".".$ext;
        // 將檔案從暫存區移動到指定的資料夾，並使用新的檔名
        move_uploaded_file($_FILES['product_img']['tmp_name'], "../upload/".$newname);
    }else{
        $newname = $old_images;
    }
    
    // 建立資料庫連線
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    // 設定連線編碼為 UTF-8
    mysqli_set_charset($conn, 'utf8');
    // 設定 SQL update指令
    $sql = "UPDATE product 
            SET product_name = '$name', 
                product_price = $price, 
                product_content = '$content', 
                product_img = '$newname', 
                product_type_id = $type_id, 
                product_state = '$state' 
            WHERE product_id = $id;";
    
    // echo $sql;
    // 執行 SQL 查詢指令 
    if(mysqli_query($conn, $sql)){
        header("Location: product.php");
    }
}
catch (Exception $e) {
    echo "連線失敗: " . $e->getMessage();
    die();
}
?>