<?php
require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";

//싱글톤 객체 불러오기
$db = DB::getInstance();
$db->sessionStart();

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
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/common.js?ver=1"></script>

        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    </head>
    <body id="body">
        <div id="title_container">
            <div>
                <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/admin/">
                    <span id="title" class="gfont_1">A4B1</span>
                    <span id="title_sub" class="gfont_3">Admin Page</span>
                </a>
            </div>
            <div id="title_function">
                <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/">
                    <span class="gfont_3">사이트로 돌아가기</span>
                </a>
            </div>
        </div>
        <div>
            <div id="side_menu">
                <ul>
                    <li>
                        <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/admin/css/admin.css?ver=1">
                            <span class="gfont_3">메인 슬라이드 관리<span>
                        </a>
                    </li>
                    <li>
                        <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/admin/css/admin.css?ver=1">
                            <span class="gfont_3">메인 슬라이드 관리<span>
                        </a>
                    </li>
                    <li>
                        <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/admin/css/admin.css?ver=1">
                            <span class="gfont_3">메인 슬라이드 관리<span>
                        </a>
                    </li>
                    <li>
                        <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/admin/css/admin.css?ver=1">
                            <span class="gfont_3">메인 슬라이드 관리<span>
                        </a>
                    </li>
                    <li>
                        <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/admin/css/admin.css?ver=1">
                            <span class="gfont_3">메인 슬라이드 관리<span>
                        </a>
                    </li>
                </ul>
            </div>
            <div id="content">

            </div>
        </div>

    </body>
</html>
