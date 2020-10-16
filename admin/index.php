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
        
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    </head>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";

    //싱글톤 객체 불러오기
    $db = DB::getInstance();
    $db->sessionStart();

    if(isset($_SESSION['admin']) && $_SESSION['admin'] >= 1) {?>
    <body id="body">
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/admin/admin_menu.php"?>
        <div id="content">
            <div id="welcome_box">
                <h2>A4B1 GameBox 관리자 페이지</h2>
                <p>슬라이드쇼 사진 / 멤버 권한 / 조회수 통계</p>
            </div>
        </div>
    </body>
    <?php } ?>
</html>
<?php
//관리자 인지 여부 체크 -> 접근 권한
if(!isset($_SESSION['admin']) || $_SESSION['admin'] < 1) {
    echo "<script>swal('접근권한 없음','해당 계정의 접근 권한이 없습니다.','error').then(() => {history.go(-1);});</script>";}
?>
