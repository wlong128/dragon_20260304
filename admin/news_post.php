<!doctype html>
<html lang="en">

<head>
    <title>新聞發佈</title>
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
            <h1>新聞發佈</h1>
            <form action="news_insert.php" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="title" class="form-label">新聞標題</label>
                        <input type="text" class="form-control" id="title" name="title" />
                    </div>
                    <div class="col-12 mb-3">
                        <label for="summary" class="form-label">新聞焦點</label>
                        <textarea name="summary" id="summary" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="content" class="form-label">新聞內容</label>
                        <textarea name="content" id="content" class="form-control" rows="8"></textarea>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="image" class="form-label">焦點圖片</label>
                        <input type="file" class="form-control" id="image" name="image" />
                    </div>
                    <div class="col-12 mb-3">
                        <label for="author" class="form-label">作者</label>
                        <input type="text" class="form-control" id="author" name="author" />
                    </div>
                    <div class="col-12 mb-3">
                        <label for="is_publish" class="form-label">是否直接發佈</label>
                        <select class="form-control" id="is_publish" name="is_publish">
                            <option value="0">否</option>
                            <option value="1">發佈</option>
                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <input type="submit" value="新增" class="btn btn-primary" />
                    </div>
                </div>
            </form>
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