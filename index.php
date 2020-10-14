<?php
require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";

//싱글톤 객체 불러오기
$db = DB::getInstance();
$db->sessionStart();
?>
<!doctype html>
<html lang="ko">
    <head>
        <meta charset="UTF-8">
        <title>A4B1's Game Box</title>

        <!--Jquery 추가-->
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/jquery/jquery-3.5.1.min.js?ver=1"></script>

        <!--헤더 파일 추가-->
        <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/css/common.css?ver=1">
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/common.js?ver=1"></script>

        <!--alert & toastr 라이브러리 추가-->
        <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/css/toastr/toastr.min.css?ver=1"/>
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/toastr/toastr.min.js?ver=1"></script>
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/sweetalert/sweetalert.min.js?ver=1"></script>

        <!--메인화면 파일 추가-->
        <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/main/css/main.css?ver=1"/>
        <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/main/js/main.js?ver=1"></script>

    </head>
    <body id="body">
        <header>
            <?php include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/header.php"; ?>
        </header>
        <div>
            <div class="slide_container">
                <div class="slideshow">
                    <div class="slideshow_slides">
                        <a href="#"><img src="http://<?=$_SERVER['HTTP_HOST']?>/source/homework/200917/img/slide-1.jpg" alt="slide1"></a>
                        <a href="#"><img src="http://<?=$_SERVER['HTTP_HOST']?>/source/homework/200917/img/slide-2.jpg" alt="slide2"></a>
                        <a href="#"><img src="http://<?=$_SERVER['HTTP_HOST']?>/source/homework/200917/img/slide-3.jpg" alt="slide3"></a>
                        <a href="#"><img src="http://<?=$_SERVER['HTTP_HOST']?>/source/homework/200917/img/slide-4.jpg" alt="slide4"></a>
                    </div>

                    <div class="slideshow_nav">
                        <a href="#" class="prev">prev</a>
                        <a href="#" class="next">next</a>
                    </div>

                    <div class="slideshow_indicator">
                        <a href="#" class="active"></a>
                        <a href="#"></a>
                        <a href="#"></a>
                        <a href="#"></a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
