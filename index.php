<?php
    require $_SERVER['DOCUMENT_ROOT']."/a4b1/common/lib/db.mysqli.class.php";
    //싱글톤 객체 불러오기
    $db = DB::getInstance();
    $dbcon = $db->MysqliConnect();
?>
<!doctype html>
<html lang="ko">
    <head>
        <meta charset="UTF-8">
        <title>A4B1's Game Box</title>
        <link rel="stylesheet" href="http://<?=$_SERVER['HTTP_HOST']?>/a4b1/common/css/common.css?ver=1">
        <script src="http://<?=$_SERVER['HTTP_HOST']?>/a4b1/common/js/common.js?ver=1"></script>
    </head>
    <body>
        <header>
            <?php include $_SERVER['DOCUMENT_ROOT']."/a4b1/common/lib/header.php";?>
        </header>
        메인페이지
    </body>
</html>
