<?php
echo $_FILES['uploadfile']['name']."<br>";
echo $_FILES['uploadfile']['size']."<br>";
echo $_FILES['uploadfile']['type']."<br>";
echo $_FILES['uploadfile']['tmp_name']."<br>";
// 設定時區為台北
date_default_timezone_set("Asia/Taipei");
// 產生新的檔名，格式為：年月日時分秒+4位亂數+副檔名
$rand = rand(1000,9999);
$time = date("YmdHis").$rand;
$ext = pathinfo($_FILES['uploadfile']['name'], PATHINFO_EXTENSION);
$newname = $time.".".$ext;
// 將檔案從暫存區移動到指定的資料夾，並使用新的檔名
move_uploaded_file($_FILES['uploadfile']['tmp_name'], "upload/".$newname);
echo "檔案上傳成功！<br>";
echo "新檔名：".$newname."<br>";
echo "<img src='upload/".$newname."' width='300'>";
?>