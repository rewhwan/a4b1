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
        <!-- 슬라이드 쇼 css -->
        <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/main/css/main_slide.css?ver=1"/>
    </head>
    <body id="body">
        <header>
            <?php include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/header.php"; ?>
        </header>
        <div>
        <div class="slideshow-container">
        <?php
                // $screen_shot = explode(",",$screen);
                // $count= count($screen_shot);
                // $i=0;
                // for($i=0; $i<$count; $i++){
                //     $screen_image= $screen_shot[$i];
                    //echo"<script>console.log($screen_shot)</script>";
                    //echo"<script>console.log('$screen_image')</script>";
                    ?>
                    <div class="mySlides fade">
                        <div class="numbertext">1 / 1</div>
                            <img src="http://<?=$_SERVER['HTTP_HOST']?>/a4b1/game_review/data/background_image2.jpg" style="width:100%">
                        </div>
                <?php
                //}
                ?>
            
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>

            </div>
            <div style="text-align:center" id="dot_container">
                <?php
                    //for($i=0; $i<$count; $i++){
                ?>
                <span class="dot" onclick="currentSlide(1)"></span> 
                <?php
                    //}
                ?>
            </div>
            <script src="http://<?=$_SERVER['HTTP_HOST']?>/a4b1/game_info/js/game_info_view_slide.js"></script>
        </div>
        <div id="game_info_view_container">
            <img src="http://<?=$_SERVER['HTTP_HOST']?>/a4b1/game_review/data/background_image2.jpg" style="width:100%">
        </div>
        <div id="game_review_view_container">
            <img src="http://<?=$_SERVER['HTTP_HOST']?>/a4b1/game_review/data/background_image2.jpg" style="width:100%">
        </div>
        <footer>
            <?php include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/footer.php"; ?>
        </footer>
    </body>
</html>
