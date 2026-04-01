<?php
// 變數
$a1 = 10;
$name = "小明";
echo $a1 . $name . "<br>";
$A1 = 20;
// 變數輸出除錯用
var_dump($A1);
$A1 = "Hello";
var_dump($A1);
$A1 = 3.14;
var_dump($A1);
$A1 = true;
var_dump($A1);

// 常數
define("PI", 3.14);
echo PI . "<br>";
define("WEB_NAME", "烏龍院");

$gender = "女";
// 三元運算子
$gender == "男" ? $str = "先生" : $str = "小姐";
echo $str;
?>
<!doctype html>
<html lang="en">

<head>
    <title><?= WEB_NAME ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
</head>

<body>
    <header>
        <div class="alert alert-primary" role="alert">
            <strong><?= WEB_NAME ?></strong> Some Word
        </div>

    </header>
    <main></main>
        
    <!-- 引入外部檔案 footer.html -->
    <div w3-include-html="footer.html"></div>
    
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>