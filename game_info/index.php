<!doctype html>
<html lang="ko">
    <head>
        <meta charset="UTF-8">
        <title>게임정보</title>
        <link rel="stylesheet" href="http://<?=$_SERVER['HTTP_HOST']?>/a4b1/common/css/common.css?ver=1">
        <script src="http://<?=$_SERVER['HTTP_HOST']?>/a4b1/common/js/common.js?ver=1"></script>
    </head>
    <body>
        <header>
            <?php include $_SERVER['DOCUMENT_ROOT']."/a4b1/common/lib/header.php";?>
        </header>
        게임정보 입니다.
        <a href="info_insert_form.php">글쓰기</a>
        <a href="game_info_list.php">리스트 보기</a>
    </body>
</html>