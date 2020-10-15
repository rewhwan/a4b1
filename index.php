<?php
require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";

//싱글톤 객체 불러오기
$db = DB::getInstance();
$db->sessionStart();
$dbcon = $db->connector();

//게임정보를 담을 배열 선언
$num_array = array();
$image_array= array();
$name_array= array();
//게임정보를 DB에서 가져오기
$sql="SELECT num,image,name from `game_info` order by num desc limit 5";
$result = mysqli_query($dbcon,$sql) or die("main_select_game_info_error1 : ".mysqli_error($dbcon));
while($row = mysqli_fetch_array($result)){
    array_push($num_array,$row['num']);
    array_push($image_array,$row['image']);
    array_push($name_array,$row['name']);
}
//리뷰 정보를 담을 배열 선언
$review_num_array = array();
$review_screen_array = array();
$review_title_array = array();
$review_created_by_array = array();
$review_rank_array = array();
//리뷰 정보를 DB에서 가져오기
$sql="SELECT * from `game_review` order by num desc limit 5";
$result2 = mysqli_query($dbcon,$sql) or die("main_select_game_review_error1 : ".mysqli_error($dbcon));
while($row = mysqli_fetch_array($result2)){
    array_push($review_num_array,$row['num']);
    array_push($review_title_array,$row['title']);
    array_push($review_created_by_array,$row['created_by']);
}
for($i = 0; $i<count($review_num_array); $i++){
    $sql = "SELECT name from `game_review_files` where `review_num` = $review_num_array[$i] order by num limit 1";
    $result_image = mysqli_query($dbcon,$sql) or die("main_select_game_review_flies_error1_: ".mysqli_error($dbcon));
    while($row = mysqli_fetch_array($result_image)){
        array_push($review_screen_array,$row['name']);
    }
}
for($i = 0; $i<count($review_num_array); $i++){
    $sql = "SELECT ((`story`+`graphic`+`time`+`difficulty`)/4) FROM `game_review_point` where `review_num` = $review_num_array[$i]";
    $result_rank = mysqli_query($dbcon,$sql) or die("main_select_game_review_point_error1 : ".mysqli_error($dbcon));
    while($row = mysqli_fetch_array($result_rank)){
        array_push($review_rank_array,number_format($row['((`story`+`graphic`+`time`+`difficulty`)/4)'],2));
    }
}
//캘린더 정보를 넣을 정보를 넣을 배열 선언
$cal_num_array= array();
$cal_name_array = array();
$cal_release_date_array = array();
$cal_image_array= array();
$cal_platform_array = array();
//신작 캘린더에 넣을 정보 가져오기
$sql="SELECT num,name,release_date,image from game_info where release_date < now() order by release_date limit 5";
$result_date = mysqli_query($dbcon,$sql) or die("main_select_game_release_date_error1 : ".mysqli_error($dbcon));
while($row=mysqli_fetch_array($result_date)){
    array_push($cal_num_array,$row['num']);
    array_push($cal_name_array,$row['name']);
    array_push($cal_release_date_array,$row['release_date']);
    array_push($cal_image_array,$row['image']);
}
for($i=0; $i<count($cal_num_array); $i++){
    $sql="SELECT * from `game_info_platform` where info_num = $cal_num_array[$i]";
    $result = mysqli_query($dbcon,$sql) or die("main_select_game_platform_error2 : ".mysqli_error($dbcon));
}
//DB 닫기
mysqli_close($dbcon);
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
        <div class="label_container">
            <label for="game_info_view_container">최신 게임 정보</label>
        </div>
        <div id="game_info_view_container">
            <?php
                for($i=0; $i<count($num_array); $i++){
            ?>
            <a href="http://<?=$_SERVER['HTTP_HOST']?>/a4b1/game_info/game_info_view.php?num=<?=$num_array[$i]?>" class="info_view_a">
                <?php
                    if($image_array[$i] != null){
                ?>
                <img src="http://<?=$_SERVER['HTTP_HOST']?>/a4b1/game_info/img/title/<?=$image_array[$i]?>" class="info_view_img">
                <?php
                    }else{
                ?>
                <img src="http://<?=$_SERVER['HTTP_HOST']?>/a4b1/game_review/data/default.png" class="info_view_img">
                <?php
                    }
                ?>
                <p><?=$name_array[$i]?></p>
            </a>
            <?php
                }
            ?>
        </div>
        <div class="label_container">
            <label for="game_review_view_container">최신 리뷰 정보</label>
        </div>
        <div id="game_review_view_container">
            <?php
                for($i=0; $i<count($review_num_array); $i++){
                    ?>
                <a href="http://<?=$_SERVER['HTTP_HOST']?>/a4b1/game_review/view.php?num=<?=$review_num_array[$i]?>&page=1" class="info_view_a">
            <?php        
                    if($review_screen_array[$i] != null){
            ?>
                <img src="http://<?=$_SERVER['HTTP_HOST']?>/a4b1/game_review/img/<?=$review_screen_array[$i]?>" class="info_view_img">
            <?php
                }else{
                ?>
                <img src="http://<?=$_SERVER['HTTP_HOST']?>/a4b1/game_review/data/default.png" class="info_view_img">
            <?php
                }
            ?>
                <p><?=$review_title_array[$i]?></p>
                <p>작성자 : <?=$review_created_by_array[$i]?></p>
                <p>별점 : <?=$review_rank_array[$i]?></p>
            </a>
            <?php
            }   
            ?>
        </div>
        <div id="calendar_notice_container">
            <div id="calendar_container">
                <div class="span_container">
                    <span>신작 캘린더</span>
                </div>
                <ul>
                    <?php
                    ?>

                    <?php
                    ?>
                </ul>
            </div>
            <div id="notice_container">
                <div class="span_container">
                    <span>공지사항</span>
                </div>
                <ul>

                </ul>
            </div>
        </div>
        <footer>
            <?php include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/footer.php"; ?>
        </footer>
    </body>
</html>
