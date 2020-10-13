<?php
session_start();
//설정한 지역의 시간대로 설정
date_default_timezone_set("Asia/Seoul");
require $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/db.mysqli.class.php";
include $_SERVER['DOCUMENT_ROOT']."/a4b1/common/lib/submit_function.php";
//싱글톤 객체 불러오기
$db = DB::getInstance();
$dbcon = $db->connector();
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Jquery 추가-->
    <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/jquery/jquery-3.5.1.min.js?ver=1"></script>
    <!-- 헤더부분 추가 -->
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/css/common.css?ver=1">
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_info/css/review.css">
    <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/common/js/common.js?ver=1"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <!-- 자바스크립트 추가 -->
    <script src="./js/info.js"></script>
    <title>게임 정보 리스트</title>
</head>

<body>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/a4b1/common/lib/header.php"; ?>
    </header>
    <?php
    $mode = $_GET['mode'];
    //상수 지정
    define('SCALE', 8);
    if($mode == "search"){
        $search = $_GET['search'];
        $search_word = strtoupper($_GET['search_word']);
        switch($search){
            case"name": 
            case"grade": $sql="SELECT * from `game_info`  where $search like '%$search_word%' order by `num` desc";
            break;
            case"genre": 
            case"platform": $sql="SELECT * from `game_info` a left join game_info_$search b on a.num=b.info_num where $search like '%$search_word%' order by a.num desc";
            break;
            default: $sql="SELECT * from `game_info` order by `num` desc";
            break;
        }
    }else{
        //전체 레코드수를 가져와 총 페이지 계산
        $sql = "SELECT * from `game_info` order by `num` desc";
    }
    $result = mysqli_query($dbcon, $sql) or die("list select error1 : " . mysqli_error($dbcon));
    $total_record = mysqli_num_rows($result);
    if($total_record == 0){
        alert_back("검색 결과가 없습니다.");
    }
    //딱 맞아 떨어지면 그대로 아니면 올림수로 계산
    $total_page = ($total_record % SCALE == 0) ? ($total_record / SCALE) : (ceil($total_record / SCALE));

    //2.페이지가 없으면 디폴트 페이지 1페이지
    if (empty($_GET['page'])) {
        $page = 1;
    } else {
        $page = $_GET['page'];
    }

    $start = ($page - 1) * SCALE;
    $number = $total_record - $start;
    ?>
    <div id="container_body">
        <div id="top">
            <ul>
            <select name="search" id="search">
                <option value="" id="option_no">선택</option>
                <option value="name" id="option_name">이름</option>
                <option value="genre" id="option_genre">장르</option>
                <option value="platform" id="option_platform">플랫폼</option>
                <option value="grade" id="option_grade">등급</option>
            </select>
                <li><input type="text" name="search_word" id="search_word"></li>
                <li><button onclick="check_search()">검색하기</button></li>
                <li><button onclick="location.href='info_insert_form.php'">글쓰기</button></li>
            </ul>
            <?php
                if(isset($_GET['search'])  && isset($_GET['search_word'])){
                    $value = $_GET['search'];
                    $word = $_GET['search_word'];
                    echo"<script>search_word_check('$value','$word');</script>";
                }
            ?>
        </div>

        <div id="list">
            <ul>
                <?php
                for ($i = $start; $i < $start + SCALE && $i < $total_record; $i++) {
                    //DB에서 게임 정보 가져오기
                    if($mode == "search"){
                        switch($search){
                            case"name": 
                            case"grade": $sql1="SELECT * from `game_info`  where $search like '%$search_word%' order by `num` desc";
                            break;
                            case"genre": 
                            case"platform": $sql1="SELECT * from `game_info` a left join game_info_$search b on a.num=b.info_num where $search like '%$search_word%' order by a.num desc";
                            break;
                            default: $sql1 = "SELECT * from `game_info` order by `num` desc";
                            break;
                        }
                    }else{
                        $sql1 = "SELECT * from `game_info` order by `num` desc";
                    }
                    
                    $result = mysqli_query($dbcon, $sql1) or die("list select error2 : " . mysqli_error($dbcon));
                    mysqli_data_seek($result, $i);
                    $row = mysqli_fetch_array($result);
                    if($mode == "search" &&($search == "genre" || $search=="platform")){
                        $num = $row['info_num'];
                    }else{
                        $num = $row['num'];
                    }
                    
                    $name = $row['name'];
                    $developer = $row['developer'];
                    $grade = $row['grade'];
                    $release_date = $row['release_date'];
                    $service_kor = $row['service_kor'];
                    if($service_kor == 1){
                        $service_kor = "지원";
                    }else{
                        $service_kor = "미 지원";
                    }
                    $image = $row['image'];
                    $created_by = $row['created_by'];
                    $created_at = $row['created_at'];

                    $sql = "SELECT * from `game_info_genre` where `info_num` = $num";
                    $result = mysqli_query($dbcon, $sql) or die("list select error3 : " . mysqli_error($dbcon));
                    $genre=null;
                    while($row1 = mysqli_fetch_array($result)){
                        if($genre == null){
                            $genre = $row1['genre'];
                        }else{
                            $genre = $genre.",".$row1['genre'];
                        }
                    }
                    $platform="";
                    $sql = "SELECT * from `game_info_platform` where `info_num` = $num";
                    $result = mysqli_query($dbcon, $sql) or die("list select error4 : " . mysqli_error($dbcon));
                    while($row2 = mysqli_fetch_array($result)){
                        if($platform == null){
                            $platform = $row2['platform'];
                        }else{
                            $platform = $platform.",".$row2['platform'];
                        }
                    }
                ?>
                <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_info/game_info_view.php?num=<?=$num?>">
                    <li>
                        <?php
                            if($image){
                        ?>
                        <img src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_info/img/title/<?=$image?>">
                        <?php
                            }else{
                        ?>
                        <img src="http://<?= $_SERVER['HTTP_HOST'] ?>/a4b1/game_review/data/default.png">
                        <?php
                            }
                        ?>
                        <h3><?= $name ?></h3>
                        <p>장르 : <?=$genre?></p>
                        <p>지원 플랫폼 : <?=$platform?></p>
                        <p>한국어 지원 : <?=$service_kor?></p>
                        <p>작성자 : <?=$created_by?></p>
                        <p>작성일자 : <?=$created_at?></p>
                        <p>등급 : <?=$grade?></p>
                    </li>
                </a>
                <?php
                     $number--;
                }
                mysqli_close($dbcon);
                ?>
            </ul>
        </div>
        <div id="page_button">
						<div id="page_num"> 
                        <?php
                         if($page != 1){
                            if($mode == "search"){
                        ?>    
                        <a href="./game_info_list.php?page=<?=$page-1?>&mode=search&search=<?=$search?>&search_word=<?=$search_word?>">이전◀</a>
                        <?php
                            }else{
                            ?>
                        <a href="./game_info_list.php?page=<?=$page-1?>">이전◀</a>
                         <?php   
                         }
                        }
                        ?>
                        &nbsp;&nbsp;&nbsp;
							<?php
							for ($i = 1; $i <= $total_page; $i++) {
								if ($page == $i) {
									echo "<b>&nbsp;$i&nbsp;</b>";
								} else {
                                    if($mode == "search"){
                                        echo "<a href='./game_info_list.php?page=$i&mode=search&search=$search&search_word=$search_word'>&nbsp;$i&nbsp;</a>";
                                    }else{
                                        echo "<a href='./game_info_list.php?page=$i'>&nbsp;$i&nbsp;</a>";
                                    }
								}
							}
							?>
                            &nbsp;&nbsp;&nbsp;
                            <?php
                            if($page != $total_page){
                                if($mode == "search"){
                            ?>
                            <a href="./game_info_list.php?page=<?=$page+1?>&mode=search&search=<?=$search?>&search_word=<?=$search_word?>">▶다음</a>
                            <?php
                                }else{
                            ?>
                            <a href="./game_info_list.php?page=<?=$page+1?>">▶다음</a>
                            <?php
                                }
                            }
                            ?>
						</div>
        </div>

</body>

</html>