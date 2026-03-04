<?php
// $_GET['p'] 代表網址列的參數，例如 http://example.com/02.php?p=apple
// isset() 函式用來檢查變數是否已經被設定，這裡用來檢查是否有輸入單字
if(!isset($_GET['p'])) {
    echo '請輸入單字';
    exit;
}
$word = $_GET['p'];
switch ($word) {
    case 'apple':
        echo '蘋果';
        break;
    case 'banana':
        echo '香蕉';
        break;
    default:
        echo '查無此單字';
}
?>