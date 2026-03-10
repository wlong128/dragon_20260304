<?php
// 列出目錄下的所有檔案
$dir = '.'; // 指定目錄
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        echo "<h2>上傳的檔案列表：</h2><ul>";
        while (($file = readdir($dh)) !== false) {
            if ($file != '.' && $file != '..') { // 排除當前和父目錄
                echo "<li><a href='$dir$file'>$file</a></li>"; // 顯示檔案名稱並提供下載連結
            }
        }
        echo "</ul>";
        closedir($dh);
    } else {
        echo "無法打開目錄。";
    }
} else {
    echo "指定的路徑不是一個目錄。";
}
?>