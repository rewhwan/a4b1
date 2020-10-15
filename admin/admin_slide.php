<?php
require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";

//싱글톤 객체 불러오기
$db = DB::getInstance();
$db->sessionStart();
$dbcon = $db->connector();

//관리자 인지 여부 체크 -> 접근 권한
if(!isset($_SESSION['admin']) || $_SESSION['admin'] < 1) {
    echo "<script>alert('접근 권한이 없습니다.')</script>";
}
?>
<!doctype html>
<html lang="ko">
    <head>
        <meta charset="UTF-8">
        <title>A4B1 Admin Stage</title>

        <!--Jquery 추가-->
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/jquery/jquery-3.5.1.min.js?ver=1"></script>

        <!--alert & toastr 라이브러리 추가-->
        <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/css/toastr/toastr.min.css?ver=1"/>
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/toastr/toastr.min.js?ver=1"></script>
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/sweetalert/sweetalert.min.js?ver=1"></script>

       <!--헤더 파일 추가-->
       <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/admin/css/admin.css?ver=1">
       <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/admin/js/admin.js?ver=1"></script>

        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    </head>
    <body id="body">
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/admin/admin_menu.php"?>
        <div id="slide_content">
            <h2>메인페이스 슬라이드쇼 사진 관리</h2>
            <ul>
                <?php
                    $sql = 'SELECT * FROM main_slide_files ORDER BY num ASC';
                    $result = mysqli_query($dbcon,$sql);
                    $resultArray = mysqli_fetch_all($result);

                    print_r($resultArray);
                ?>
            </ul>
        </div>
    </body>

    <div id="insert_form">
        <h2>슬라이드쇼 사진 추가 하기</h2>
        <input type="file" id="slide_file" name="slide_file[]" multiple accept="image/*">
        <button onclick="submit_slide()">추가</button>
    </div>
</html>
